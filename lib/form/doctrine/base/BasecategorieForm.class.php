<?php

/**
 * categorie form base class.
 *
 * @method categorie getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasecategorieForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'parent_id'              => new sfWidgetFormInputText(),
      'article_categorie_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'article_categorie')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'parent_id'              => new sfValidatorInteger(array('required' => false)),
      'article_categorie_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'article_categorie', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('categorie[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'categorie';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['article_categorie_list']))
    {
      $this->setDefault('article_categorie_list', $this->object->article_categorie->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savearticle_categorieList($con);

    parent::doSave($con);
  }

  public function savearticle_categorieList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['article_categorie_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->article_categorie->getPrimaryKeys();
    $values = $this->getValue('article_categorie_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('article_categorie', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('article_categorie', array_values($link));
    }
  }

}
