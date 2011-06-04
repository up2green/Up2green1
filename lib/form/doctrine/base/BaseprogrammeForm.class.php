<?php

/**
 * programme form base class.
 *
 * @method programme getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseprogrammeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'organisme_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => true)),
      'geoadress'       => new sfWidgetFormInputText(),
      'is_active'       => new sfWidgetFormInputCheckbox(),
      'max_tree'        => new sfWidgetFormInputText(),
      'add_tree'        => new sfWidgetFormInputText(),
      'logo'            => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'polygonnes_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'polygonne')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'organisme_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'required' => false)),
      'geoadress'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_active'       => new sfValidatorBoolean(array('required' => false)),
      'max_tree'        => new sfValidatorInteger(),
      'add_tree'        => new sfValidatorInteger(array('required' => false)),
      'logo'            => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'polygonnes_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'polygonne', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('programme[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'programme';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['polygonnes_list']))
    {
      $this->setDefault('polygonnes_list', $this->object->Polygonnes->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savePolygonnesList($con);

    parent::doSave($con);
  }

  public function savePolygonnesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['polygonnes_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Polygonnes->getPrimaryKeys();
    $values = $this->getValue('polygonnes_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Polygonnes', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Polygonnes', array_values($link));
    }
  }

}
