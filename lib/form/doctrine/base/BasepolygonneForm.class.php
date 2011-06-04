<?php

/**
 * polygonne form base class.
 *
 * @method polygonne getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepolygonneForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'unique_name'     => new sfWidgetFormInputText(),
      'programmes_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'programme')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'unique_name'     => new sfValidatorString(array('max_length' => 30)),
      'programmes_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'programme', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'polygonne', 'column' => array('unique_name')))
    );

    $this->widgetSchema->setNameFormat('polygonne[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'polygonne';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['programmes_list']))
    {
      $this->setDefault('programmes_list', $this->object->Programmes->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveProgrammesList($con);

    parent::doSave($con);
  }

  public function saveProgrammesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['programmes_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Programmes->getPrimaryKeys();
    $values = $this->getValue('programmes_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Programmes', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Programmes', array_values($link));
    }
  }

}
