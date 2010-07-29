<?php

/**
 * category form base class.
 *
 * @method category getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecategoryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'unique_name'   => new sfWidgetFormInputText(),
      'is_active'     => new sfWidgetFormInputCheckbox(),
      'root_id'       => new sfWidgetFormInputText(),
      'lft'           => new sfWidgetFormInputText(),
      'rgt'           => new sfWidgetFormInputText(),
      'level'         => new sfWidgetFormInputText(),
      'articles_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'article')),
      'liens_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'lien')),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'unique_name'   => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'is_active'     => new sfValidatorBoolean(array('required' => false)),
      'root_id'       => new sfValidatorInteger(array('required' => false)),
      'lft'           => new sfValidatorInteger(array('required' => false)),
      'rgt'           => new sfValidatorInteger(array('required' => false)),
      'level'         => new sfValidatorInteger(array('required' => false)),
      'articles_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'article', 'required' => false)),
      'liens_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'lien', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'category', 'column' => array('unique_name')))
    );

    $this->widgetSchema->setNameFormat('category[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'category';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['articles_list']))
    {
      $this->setDefault('articles_list', $this->object->Articles->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['liens_list']))
    {
      $this->setDefault('liens_list', $this->object->Liens->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveArticlesList($con);
    $this->saveLiensList($con);

    parent::doSave($con);
  }

  public function saveArticlesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['articles_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Articles->getPrimaryKeys();
    $values = $this->getValue('articles_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Articles', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Articles', array_values($link));
    }
  }

  public function saveLiensList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['liens_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Liens->getPrimaryKeys();
    $values = $this->getValue('liens_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Liens', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Liens', array_values($link));
    }
  }

}
