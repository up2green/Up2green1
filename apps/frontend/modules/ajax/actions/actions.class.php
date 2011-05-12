<?php

/**
 * ajax actions.
 *
 * @package    up2green
 * @subpackage ajax
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ajaxActions extends sfActions
{
	public function executeGetKML(sfWebRequest $request) {
		$this->organismes = Doctrine_Core::getTable('organisme')->getActive();
		$this->programmes = Doctrine_Core::getTable('programme')->getActive();
	}
		
	public function executeClicPub(sfWebRequest $request) {
		$params = $request->getParameterHolder();
		$url = $params->get('url');
		$this->messageImage = '/images/icons/48x48/tick.png';
		
		if($this->getUser()->isAuthenticated()) {

			$log = Doctrine_Core::getTable('logPub')
				->getForUrlAndUser($url, $this->getUser()->getGuardUser()->getId());

			if(empty($log)) {
				$log = new logPub();
				$log->setIp($_SERVER['REMOTE_ADDR']);
				$log->setUserId($this->getUser()->getGuardUser()->getId());
				$log->setUrl($url);
				$log->save();
				
				$profil = $this->getUser()->getGuardUser()->getProfile();
				$profil->setCredit($profil->getCredit() + sfConfig::get('app_gain_cpc'));
				$profil->save();
				
				$this->message = 'success';
				$this->messageType = 'flash_notice';
			}
			else {
				$this->message = 'error-log';
				$this->messageType = 'error';
				$this->messageImage = '/images/icons/48x48/warning.png';
			}
			
		}
		else {
			$this->message = 'not-connected';
			$this->messageType = 'flash_notice';
			$this->messageImage = '/images/icons/48x48/warning.png';
		}
  }

  public function executeMoreresults(sfWebRequest $request)
  {
      $params = $request->getParameterHolder();

      $min = $params->get('nb_items_affiche');
      $minPub = $params->get('nb_pub');
      $minAffiliate = $params->get('nb_affiliate');
      $text = $params->get('text_search');
      $moteur = $params->get('moteur_search');
      $engine = new SearchEngine($text, $moteur);

	  $this->pubResults = array();
	  $this->results = array();

	  switch($moteur) {
		  case SearchEngine::SHOP :
			  $this->affiliateResults = $engine->getResults($min);
			  break;
		  case SearchEngine::WEB :
		  case SearchEngine::NEWS :
			  $this->pubResults = $engine->getPubResults(2, $minPub);
		  default :
			  $this->affiliateResults = $engine->getOneShopResult($minAffiliate);
			  $this->results = $engine->getResults($min);
			  break;
	  }

      if(empty($this->affiliateResults)) {
		  $this->affiliateResults = array();
	  }
      
  }
}
