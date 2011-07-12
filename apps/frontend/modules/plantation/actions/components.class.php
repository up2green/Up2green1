<?php

/**
 * plantation components.
 *
 * @package    up2green
 * @subpackage plantation
 * @author     Clément Gautier
*/
class plantationComponents extends sfComponents {
	public function executeMap(sfWebRequest $request) {
    $this->mapModeForm = new MapModeForm();
    if ($request->hasParameter('mapMode')) {
      $this->mapModeForm->bind($request->getParameter('mapMode'));
		}
    
		$this->gmapID = sfConfig::get('app_google_maps_api_keys');
    $this->gmapID = $this->gmapID[$_SERVER['HTTP_HOST']];

    $this->kmlURL = sfConfig::get('app_url_moteur');
    $this->kmlURL .= substr(url_for("@get_kml"), 1);
    $this->kmlURL .= '?key='.uniqid();
    
    if(isset($partenaire)) {
      $this->kmlURL .= '&partenaire='.$partenaire->getId();
    }
    
    $values = $this->mapModeForm->getValues() ? $this->mapModeForm->getValues() : $this->mapModeForm->getDefaults();
    
    $this->kmlURL .= '&displayProgrammePartenaire='.(int)$values['displayProgrammePartenaire'];
    $this->kmlURL .= '&displayProgrammeActif='.(int)$values['displayProgrammeActif'];
    $this->kmlURL .= '&displayProgrammeInactif='.(int)$values['displayProgrammeInactif'];
    $this->kmlURL .= '&displayOrganismeActif='.(int)$values['displayOrganismeActif'];
    $this->kmlURL .= '&displayOrganismeInactif='.(int)$values['displayOrganismeInactif'];
    
	}
  
	public function executeMapLegend(sfWebRequest $request) {
		$this->mapModeForm = new MapModeForm();
		if ($request->hasParameter('mapMode')) {
      $this->mapModeForm->bind($request->getParameter('mapMode'));
		}
	}
}
