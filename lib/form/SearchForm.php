<?php

/**
 * Main input / search form
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 */
class SearchForm extends BaseForm
{
  public function configure()
  {
    $this->disableLocalCSRFProtection();

    $this->setWidgets(array(
      'q'           => new sfWidgetFormInputText(array(), array('required' => true)),
      'type'				=> new sfWidgetFormInputHidden(array('default' => SearchEngine::WEB)),
    ));

    $this->setValidators(array(
      'q'             => new sfValidatorString(array('required' => true)),
      'type'          => new sfValidatorChoice(array(
        'choices'   => SearchEngine::getAvailableTypes(),
        'required'  => true,
      ))
    ));
  }
}
