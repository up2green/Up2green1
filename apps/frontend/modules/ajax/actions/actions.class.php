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
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeMoreresults(sfWebRequest $request)
  {
      $params = $request->getParameterHolder();
	  
      $min = $params->get('nb_items_affiche');
      $minPub = $params->get('nb_pub');
      $minAffiliate = $params->get('nb_affiliate');
      $text = $params->get('text_search');
      $moteur = $params->get('moteur_search');

      $engine = new SearchEngine($text, $moteur);
	  
	  $affiliateResult = $engine->getOneShopResult($minAffiliate);
	  
      $this->results = $engine->getResults($min);
      $this->affiliateResults = empty($affiliateResult) ? array() : array($affiliateResult);
      $this->pubResults = $engine->getPubResults(2, $minPub);
  }
}
