<?php

/**
 * programmePoint form base class.
 *
 * @method programmePoint getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseprogrammePointForm extends pointForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['programme_id'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['programme_id'] = new sfValidatorChoice(array('choices' => array($this->getObject()->get('programme_id')), 'empty_value' => $this->getObject()->get('programme_id'), 'required' => false));

    $this->widgetSchema->setNameFormat('programme_point[%s]');
  }

  public function getModelName()
  {
    return 'programmePoint';
  }

}
