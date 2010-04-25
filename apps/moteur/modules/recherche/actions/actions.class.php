<?php

/**
 * recherche actions.
 *
 * @package    up2green
 * @subpackage recherche
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rechercheActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      $params = $request->getParameterHolder();
      if ($strRecherche = $params->get('recherche_text')) {
          $this->textRecherche = $strRecherche;
          
      }
      else $this->textRecherche = "";

      $this->results = array();
  }
}
