<?php

/**
 * recherche actions.
 *
 * @package    up2green
 * @subpackage recherche
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rechercheActions extends sfActions {
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $params = $request->getParameterHolder();
        if ($strRecherche = $params->get('recherche_text')) {
            $this->moteur = $params->get('recherche_moteur');
            $this->textRecherche = $strRecherche;
            $engine = new SearchEngine($this->textRecherche, $this->moteur);
            $this->results = $engine->getResults();
        }
        else {
            $this->textRecherche = "";
            $this->results = array();
            $this->moteur = "";
        }
    }
}
