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
		$this->step = $request->getParameter("step", "choice");
		$this->forward404Unless($this->getUser()->isAuthenticated());
		$this->forward404Unless(in_array($this->step, array("choice", "dest", "buy",  "final")));
		
		$user = $this->getUser()->getGuardUser();
		$this->partenaire = ($user->getPartenaire()->getId() != null ? $user->getPartenaire() : null);
		$this->vars = array(); // subtemplate vars
		
		switch($this->step) {
			case 'choice' :
				$this->vars['products'] = Doctrine_Core::getTable('couponGen')
							->addPurchasableQuery()
							->addWhere('c.is_partenaire_only = ?', !is_null($this->partenaire))
							->execute();
				break;
			
			case 'dest' :
				$productId = $request->getParameter('product', 0);
				$this->forward404If(empty ($productId));
				$this->vars['product'] = Doctrine_Core::getTable('couponGen')->findOneById(key($productId));
				$this->forward404Unless($this->vars['product']);
				
				break;
				
			case 'buy' :
				$productId = $request->getParameter('product_id', 0);
				$this->vars['toMail'] = $request->getParameter('to_mail', '');
				$this->vars['toName'] = $request->getParameter('to_name', '');
				$this->vars['fromName'] = $request->getParameter('from_name', '');
				$this->vars['message'] = $request->getParameter('message', '');
				
				$this->forward404If(empty ($productId) || empty ($this->vars['toMail']));
				$this->vars['product'] = Doctrine_Core::getTable('couponGen')->findOneById($productId);
				$this->forward404If(empty ($this->vars['product']));
				
				$this->vars['payments'] = sfConfig::get('app_payements_enabled');
				break;
				
			case 'final' :
				$productId = $request->getParameter('product_id', 0);
				$toMail = $request->getParameter('to_mail', '');
				$payment = $request->getParameter('payment', 0);
				$this->forward404Unless($payment);
				$payment = key($payment);
				$this->forward404Unless(in_array($payment, sfConfig::get('app_payements_enabled')));
				$this->forward404If(empty ($productId) || empty ($toMail));
				$this->product = Doctrine_Core::getTable('couponGen')->findOneById($productId);
				$this->forward404Unless($this->product);
				
				switch ($payment) {
					case 'paypal':
						$data = new PaypalPaymentData();
						$data->subject = 'Up2green reforestation';
						$this->payment = Payment::create(
							(float)$this->product->getPrix(), 
							'EUR',
							$data
						);

						$data->cancel_url = $this->context->getController()->genUrl(array(
							'module' => 'user',
							'action' => 'profil',
							'reference' => $this->payment->id,
						), true);
						$data->return_url = $this->context->getController()->genUrl(array(
							'module' => 'user',
							'action' => 'listCoupon',
							'reference' => $this->payment->id,
						), true);
						$data->save();
						
						try {
							if ($this->payment->hasOpenTransaction()) {
								$this->payment->getOpenTransaction()->execute();
							}
							else {
								$this->payment->approve();
							}
						}
						catch (jmsPaymentException $e) {
							// for now there is only one action, so we do not need additional
							// processing here
							if ($e instanceof jmsPaymentUserActionRequiredException
									&& $e->getAction() instanceof jmsPaymentUserActionVisitURL) {
								$this->redirect($e->getAction()->getUrl());
							}

							$this->error = $e->getMessage();

							return 'Error';
						}
						break;
				}
				
				break;
		}		
		
		$this->vars['partenarie'] = $this->partenaire;
		
  }
	
  public function executeCredit(sfWebRequest $request) {
    $this->step = $request->getParameter("step", "choice");
		$this->forward404Unless($this->getUser()->isAuthenticated());
		$this->forward404Unless(in_array($this->step, array("choice", "buy",  "final")));
		
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
					$this->redirect('checkout/credit');
				}
				
				$this->vars['credit'] = $credit;
				$this->vars['payments'] = sfConfig::get('app_payements_enabled');
				break;
		}		
		
  }
}
