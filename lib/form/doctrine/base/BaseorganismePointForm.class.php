<?php

/**
 * organismePoint form base class.
 *
 * @method organismePoint getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseorganismePointForm extends pointForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['organisme_id'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['organisme_id'] = new sfValidatorChoice(array('choices' => array($this->getObject()->get('organisme_id')), 'empty_value' => $this->getObject()->get('organisme_id'), 'required' => false));

    $this->widgetSchema->setNameFormat('organisme_point[%s]');
  }

  public function getModelName()
  {
    return 'organismePoint';
  }

}
