<?php

/**
 * Mode of the Google Map form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 */
class MapModeForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'displayProgrammeActif'				=> new sfWidgetFormInputCheckbox(),
      'displayProgrammeInactif'			=> new sfWidgetFormInputCheckbox(),
      'displayOrganismeActif'				=> new sfWidgetFormInputCheckbox(),
      'displayOrganismeInactif'			=> new sfWidgetFormInputCheckbox(),
      'displayProgrammePartenaire'	=> new sfWidgetFormInputCheckbox(),
    ));
    
    $this->setValidators(array(
      'displayProgrammeActif'				=> new sfValidatorBoolean(),
      'displayProgrammeInactif'			=> new sfValidatorBoolean(),
      'displayOrganismeActif'				=> new sfValidatorBoolean(),
      'displayOrganismeInactif'			=> new sfValidatorBoolean(),
      'displayProgrammePartenaire'	=> new sfValidatorBoolean(),
    ));
    
	$this->widgetSchema->setNameFormat('mapMode[%s]');
  }
}
