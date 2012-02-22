<?php

/**
 * plantation components.
 *
 * @package    up2green
 * @subpackage plantation
 * @author     Clément Gautier
 */
class plantationComponents extends sfComponents
{

  public function executeMap(sfWebRequest $request)
  {
    $this->bindMapModeForm($request);

    $this->gmapID = sfConfig::get('app_google_maps_api_keys');
    $this->gmapID = $this->gmapID[$_SERVER['HTTP_HOST']];

    $this->kmlURL = sfConfig::get('app_url_moteur');
    $this->kmlURL .= substr(url_for("@get_kml"), 1);
    $this->kmlURL .= '?key=' . uniqid();

    $this->partenaire = null;
    $username = $request->getParameter('partenaire');
    if ($username) {
      $user = Doctrine_Core::getTable('sfGuardUser')->findOneBy('username', $username);
      if ($user) {
        $this->partenaire = $user->getPartenaire();
      }
    }

    if ($this->partenaire) {
      $this->kmlURL .= '&partenaire=' . $this->partenaire->getId();
    }

    $values = $this->getUser()->getMapMode($this->mapModeForm->getDefaults());
    if ($this->mapModeForm->getValues()) {
      $values = $this->mapModeForm->getValues();
      $this->getUser()->setMapMode($values);
    }
    $values = $this->mapModeForm->getValues() ? $this->mapModeForm->getValues() : $this->mapModeForm->getDefaults();

    $this->kmlURL .= '&displayProgrammePartenaire=' . (int) $values['displayProgrammePartenaire'];
    $this->kmlURL .= '&displayProgrammeActif=' . (int) $values['displayProgrammeActif'];
    $this->kmlURL .= '&displayProgrammeInactif=' . (int) $values['displayProgrammeInactif'];
    $this->kmlURL .= '&displayOrganismeActif=' . (int) $values['displayOrganismeActif'];
    $this->kmlURL .= '&displayOrganismeInactif=' . (int) $values['displayOrganismeInactif'];
  }

  public function executeMapLegend(sfWebRequest $request)
  {
    $this->bindMapModeForm($request);
    $this->partenaire = null;
    $username = $request->getParameter('partenaire');
    if ($username) {
      $user = Doctrine_Core::getTable('sfGuardUser')->findOneBy('username', $username);
      if ($user) {
        $this->partenaire = $user->getPartenaire();
      }
    }
  }

  private function bindMapModeForm(sfWebRequest $request)
  {
    if (empty($this->mapModeForm)) {
      if ($request->hasParameter('mapMode')) {
        $this->mapModeForm = new MapModeForm();
        $this->mapModeForm->bind($request->getParameter('mapMode'));
      } else if ($request->hasParameter('partenaire')) {
        $this->mapModeForm = new MapModeForm(array(
            'displayProgrammePartenaire' => true,
            'displayProgrammeActif'      => false,
            'displayProgrammeInactif'    => false,
            'displayOrganismeActif'      => false,
            'displayOrganismeInactif'    => false,
          ));
      } else {
        $this->mapModeForm = new MapModeForm(array(
            'displayProgrammePartenaire' => false,
            'displayProgrammeActif'      => true,
            'displayProgrammeInactif'    => true,
            'displayOrganismeActif'      => false,
            'displayOrganismeInactif'    => false,
          ));
      }
    }
  }

}
