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
				
				$payments = sfConfig::get('app_payements_enabled');
				$this->vars['payments'] = array();
				foreach ($payments as $payment) {
					$this->vars['payments'][] = array(
							'name' => $payment
					);
				}
				
				break;
				
			case 'final' :
				$productId = $request->getParameter('product_id', 0);
				$toMail = $request->getParameter('to_mail', '');
				
				$this->forward404If(empty ($productId) || empty ($this->vars['toMail']));
				$this->vars['product'] = Doctrine_Core::getTable('couponGen')->findOneById($productId);
				$this->forward404If(empty ($this->vars['product']));
				
				
				break;
		}		
		
		$this->vars['partenarie'] = $this->partenaire;
		
  }
	
  public function executeCredit(sfWebRequest $request) {
    
  }
}
