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
//      $max = $min + sfConfig::get('app_max_item_search');
      $text = $params->get('text_search');
      $moteur = $params->get('moteur_search');
      $engine = new SearchEngine($text, $moteur);
      $this->results = $engine->getResults($min);
  }
}
