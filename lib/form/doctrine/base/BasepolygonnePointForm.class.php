<?php

/**
 * polygonnePoint form base class.
 *
 * @method polygonnePoint getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepolygonnePointForm extends pointForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['polygonne_id'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['polygonne_id'] = new sfValidatorChoice(array('choices' => array($this->getObject()->get('polygonne_id')), 'empty_value' => $this->getObject()->get('polygonne_id'), 'required' => false));

    $this->widgetSchema->setNameFormat('polygonne_point[%s]');
  }

  public function getModelName()
  {
    return 'polygonnePoint';
  }

}
