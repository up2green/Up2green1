<?php

/**
 * checkout actions.
 *
 * @package    up2green
 * @subpackage checkout
 * @author     Clément Gautier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class checkoutActions extends sfActions
{
  public function executeIndex(sfWebRequest $request) {
    $this->forward404();
  }
	
  public function executeCoupon(sfWebRequest $request) {
		sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
		
		$this->step = $request->getParameter("step", "choice");
		$this->forward404Unless($this->getUser()->isAuthenticated());
		$this->forward404Unless(in_array($this->step, array("choice", "dest", "buy",  "final", "complete")));
		
		$user = $this->getUser()->getGuardUser();
		$this->partenaire = ($user->getPartenaire()->getId() != null ? $user->getPartenaire() : null);
		$this->vars = array(); // subtemplate vars
		
		switch($this->step) {
			case 'choice' :
				$this->vars['products'] = Doctrine_Core::getTable('couponGen')
					->addPurchasableQuery()
					->addWhere('c.is_partenaire_only = ?', !is_null($this->partenaire))
					->addWhere('c.credit > ?', 0)
					->execute();
				break;
			
			case 'dest' :
				$productId = $request->getParameter('product', 0);
				$this->forward404Unless($productId);
				$this->vars['product'] = Doctrine_Core::getTable('couponGen')->findOneById($productId);
				$this->forward404Unless($this->vars['product']);
				
				break;
				
			case 'buy' :
				$productId = $request->getParameter('product_id', 0);
				$this->vars['toMail'] = strip_tags($request->getParameter('to_mail', ''));
				$this->vars['toName'] = strip_tags($request->getParameter('to_name', ''));
				$this->vars['fromName'] = strip_tags($request->getParameter('from_name', ''));
				$this->vars['message'] = nl2br(strip_tags($request->getParameter('message', '')));
				
				$this->forward404If(empty ($productId) || empty ($this->vars['toMail']));
				$this->vars['product'] = Doctrine_Core::getTable('couponGen')->findOneById($productId);
				$this->forward404If(empty ($this->vars['product']));
				
				$sessionDatas = array(
					'toMail' => $this->vars['toMail'],
					'toName' => $this->vars['toName'],
					'fromName' => $this->vars['fromName'],
					'message' => $this->vars['message'],
				);
				
				$this->getUser()->setAttribute('tmp-checkout-mail-data', $sessionDatas);
				
				$this->vars['payments'] = sfConfig::get('app_payments_enabled');
				$this->vars['commissions'] = array();
				foreach ($this->vars['payments'] as $payment) {
					$this->vars['commissions'][$payment] = $this->vars['product']->getPrix() * ($this->getCommission($payment, $this->vars['product']->getPrix()) - 1);
				}
				break;
				
			case 'final' :
				$productId = $request->getParameter('product_id', 0);
				$this->forward404Unless($this->getUser()->hasAttribute('tmp-checkout-mail-data'));
				
				$paymentType = $request->getParameter('payment', 0);
				$this->forward404Unless(in_array($paymentType, sfConfig::get('app_payments_enabled')));
				
				$this->forward404Unless($productId);
				$this->product = Doctrine_Core::getTable('couponGen')->findOneById($productId);
				$this->forward404Unless($this->product);
				
				switch ($paymentType) {
					case 'paypal':
						$commission = $this->getCommission($paymentType, $this->product->getPrix());
						
						$data = new PaypalPaymentData();
						$data->subject = __('Up2green reforestation, achat de coupon');
						$data->payment_text = __("Achat d'un cuopon de {number} abre(s) sur le site up2green. Prix total : {price}", array(
								'{number}' => $this->product->getCredit(),
								'{price}' => $this->product->getPrix() * $commission,
						));
						
						$data->ip = $_SERVER['REMOTE_ADDR'];
						$data->internal_reference_number = $this->product->getId();
						$this->payment = Payment::create($this->product->getPrix() * $commission, 'EUR', $data);
						
						$data->cancel_url = $this->context->getController()->genUrl(array(
							'module' => 'checkout',
							'action' => 'coupon',
							'step' => 'choice'
						), true);
						
						$data->return_url = $this->context->getController()->genUrl(array(
							'module' => 'checkout',
							'action' => 'coupon',
							'step' => 'complete',
							'payment' => $this->payment->id,
							'paymentType' => $paymentType,
						), true);
						
						$data->save();
						
						try {
							if ($this->payment->hasOpenTransaction()) {
								$this->payment->getOpenTransaction()->execute();
							}
							$this->payment->approve();
						}
						catch (jmsPaymentException $e) {
							// for now there is only one action, so we do not need additional
							// processing here
							if ($e instanceof jmsPaymentUserActionRequiredException
									&& $e->getAction() instanceof jmsPaymentUserActionVisitURL) {
								$this->redirect($e->getAction()->getUrl());
							}

							$this->error = $e->getMessage();
						}
						
						$request->setParameter('step', 'complete');
						$this->forward('checkout/coupon');
						break;
				}
				
				break;
				
			case 'complete' :
				$paymentType = $request->getParameter('paymentType', 0);
				$this->forward404Unless(in_array($paymentType, sfConfig::get('app_payments_enabled')));
				
				$payment = Doctrine_Core::getTable('Payment')->createQuery('p')
					->leftJoin('p.DataContainer d')
					->leftJoin('p.Transactions t')
					->where('p.id = ?', $request->getParameter('payment'))
					->fetchOne();
				
				$this->forward404Unless($payment);
				
				$productId = $payment->getDataContainer()->getInternalReferenceNumber();
				$this->product = Doctrine_Core::getTable('couponGen')->findOneById($productId);
				$this->forward404Unless($this->product);
				
				$sessionDatas = $this->getUser()->getAttribute('tmp-checkout-mail-data');
				$this->forward404Unless($sessionDatas);
				
				switch($paymentType) {
					case 'paypal' :
						$this->vars['error'] = null;
						$this->vars['product'] = $this->product;
						$this->vars['mail'] = $sessionDatas['toMail'];
						$this->vars['payment'] = $payment;
						
						if($payment->getState() !== PluginPayment::STATE_COMPLETE) {
							try {
								if ($payment->hasOpenTransaction()) {
									$payment->getOpenTransaction()->execute();
								}
								$payment->deposit();
								// on créer le coupon à l'utilisateur
								$code = $this->getUser()->getGuardUser()->generateCoupon($this->product);
								// on envois le mail à son coupain
								$newsletter = Doctrine_Core::getTable('newsletter')->getBySlug('offer-coupon');
								$title = $newsletter->getTitle();
								$title = str_replace('%username%', (empty ($sessionDatas['fromName']) ? $this->getUser()->getGuardUser()->getEmailAddress() : $sessionDatas['fromName']), $title);
								
								$message = $this->getMailer()->compose(
									array($newsletter->getEmailFrom() => 'Up2Green'),
									$sessionDatas['toMail'],
									$title
								);

								$fromUserName = (empty ($sessionDatas['fromName']) ? $this->getUser()->getGuardUser()->getEmailAddress() : $sessionDatas['fromName'] . ' ('.$this->getUser()->getGuardUser()->getEmailAddress().')');
								$userMessage = '';
								if(!empty($sessionDatas['message'])) {
									$userMessage = '<p>'.__("{username} vous fait parvenir ce message :", array(
											'{username}' => $fromUserName,
									)).'</p>';
									$userMessage .= '<p>'.$sessionDatas['message'].'</p>';
								}
								
								$html = $newsletter->getContent();
								$html = str_replace('%username1%', (empty ($sessionDatas['toName']) ? $sessionDatas['toMail'] : $sessionDatas['toName']), $html);
								$html = str_replace('%username2%', $fromUserName, $html);
								$html = str_replace('%number%', $this->product->getCredit(), $html);
								$html = str_replace('%code%', $code, $html);
								$html = str_replace('%message%',$userMessage , $html);
								
								$message->setBody($html, 'text/html');

								$this->getMailer()->send($message);
							}
							catch (jmsPaymentException $e) {
								$this->vars['message'] = $e->getMessage();
								$this->vars['error'] = ($e instanceof jmsPaymentApprovalExpiredException) ? 'expired' : 'error';
							}
						}

						break;
				}
				break;
		}		
		
		$this->vars['partenarie'] = $this->partenaire;
		
  }
	
  public function executeCredit(sfWebRequest $request) {
		sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
		
    $this->step = $request->getParameter("step", "choice");
		
		$this->forward404Unless(in_array($this->step, array("choice", "buy", "final", "complete")));
		$this->forwardUnless($this->getUser()->isAuthenticated(), 'sfGuardAuth', 'signin');
		
		$user = $this->getUser()->getGuardUser();
		$this->partenaire = ($user->getPartenaire()->getId() != null ? $user->getPartenaire() : null);
		$this->vars = array(); // subtemplate vars
		switch($this->step) {
			case 'choice' :
				break;
			
			case 'buy' :
				$credit = $request->getParameter('credit', 0);
				
				if(empty ($credit)) {
					$this->getUser()->setFlash('notice', 'empty-value');
					$request->setParameter('step', 'choice');
					$this->forward('checkout/credit');
				}
				
				$this->vars['credit'] = $credit;
				$this->vars['prix'] = (float)$credit*sfConfig::get('app_prix_credit');
				$this->vars['payments'] = sfConfig::get('app_payments_enabled');
				$this->vars['commissions'] = array();
				foreach ($this->vars['payments'] as $payment) {
					$this->vars['commissions'][$payment] = $this->vars['prix'] * ($this->getCommission($payment, $this->vars['prix']) - 1);
				}
				
				break;
				
			case 'final' :
				$credit = $request->getParameter('credit', 0);
				
				if(empty ($credit)) {
					$this->getUser()->setFlash('notice', 'empty-value');
					$request->setParameter('step', 'choice');
					$this->forward('checkout/credit');
				}
				
				$paymentType = $request->getParameter('payment', 0);
				
				if(empty ($paymentType) || !in_array($paymentType, sfConfig::get('app_payments_enabled'))) {
					$this->getUser()->setFlash('notice', 'empty-payment');
					$request->setParameter('step', 'buy');
					$this->forward('checkout/credit');
				}
				
				switch ($paymentType) {
					case 'paypal':
						$commission = $this->getCommission($paymentType, (float)$credit*sfConfig::get('app_prix_credit'));
						$prixTotal = (float)$credit*sfConfig::get('app_prix_credit') * $commission;
						
						$data = new PaypalPaymentData();
						$data->subject = __('Up2green reforestation, achat de crédit');
						$data->payment_text = __('Achat de {number} crédit(s) sur le site up2green. Prix total : {price}', array(
								'{number}' => $credit,
								'{price}' => $prixTotal,
						));
						$data->ip = $_SERVER['REMOTE_ADDR'];
						
						$this->payment = Payment::create($prixTotal, 'EUR', $data);
						
						$data->cancel_url = $this->context->getController()->genUrl(array(
							'module' => 'checkout',
							'action' => 'credit',
							'step' => 'buy',
							'credit' => $credit,
						), true);
						
						$data->return_url = $this->context->getController()->genUrl(array(
							'module' => 'checkout',
							'action' => 'credit',
							'step' => 'complete',
							'payment' => $this->payment->id,
							'paymentType' => $paymentType,
						), true);
						
						$data->save();
						
						
						try {
							if ($this->payment->hasOpenTransaction()) {
								$this->payment->getOpenTransaction()->execute();
							}
							$this->payment->approve();
						}
						catch (jmsPaymentException $e) {
							// for now there is only one action, so we do not need additional
							// processing here
							if ($e instanceof jmsPaymentUserActionRequiredException
									&& $e->getAction() instanceof jmsPaymentUserActionVisitURL) {
								$this->redirect($e->getAction()->getUrl());
							}

							$this->error = $e->getMessage();
						}
						
						$request->setParameter('step', 'complete');
						$this->forward('checkout/credit');
						break;
				}
				break;
				
			case 'complete' :
				$paymentType = $request->getParameter('paymentType', 0);
				$this->forward404Unless(in_array($paymentType, sfConfig::get('app_payments_enabled')));
				
				$payment = Doctrine_Core::getTable('Payment')->createQuery('p')
					->leftJoin('p.DataContainer d')
					->leftJoin('p.Transactions t')
					->where('p.id = ?', $request->getParameter('payment'))
					->fetchOne();

				$this->forward404Unless($payment);
				
				switch($paymentType) {
					case 'paypal' :
						$this->vars['error'] = null;
						$this->vars['credit'] = $payment->getTargetAmount() / $this->getRetroCommission($paymentType, $payment->getTargetAmount()) / sfConfig::get('app_prix_credit');
						$this->vars['payment'] = $payment;
						
						if($payment->getState() !== PluginPayment::STATE_COMPLETE) {
							try {
								if ($payment->hasOpenTransaction()) {
									$payment->getOpenTransaction()->execute();
								}
								$payment->deposit();
								$this->getUser()->getGuardUser()->getProfile()->addCredit($this->vars['credit']);
							}
							catch (jmsPaymentException $e) {
								$this->vars['message'] = $e->getMessage();
								$this->vars['error'] = ($e instanceof jmsPaymentApprovalExpiredException) ? 'expired' : 'error';
							}
						}

						break;
				}
				break;
				
			}
		}	
		
	public function getCommission($paymentType, $prix) {
		// memo tarification progressive paypal :
		//€0,00 EUR - €2 500,00 EUR 	3,4% + €0,25 EUR
		//€2 500,01 EUR - €10 000,00 EUR 	2,0% + €0,25 EUR
		//€10 000,01 EUR - €50 000,00 EUR 	1,8% + €0,25 EUR
		//€50 000,01 EUR - €100 000,00 EUR 	1,6% + €0,25 EUR
		//> €100 000,00 EUR 	1,4% + €0,25 EUR
		switch($paymentType) {
			case 'paypal' : return 1.034;
			default : return 1;
		}
	}

	public function getRetroCommission($paymentType, $prix) {
			switch($paymentType) {
				case 'paypal' : return 1.034;
				default : return 1;
			}
		}
	
}
