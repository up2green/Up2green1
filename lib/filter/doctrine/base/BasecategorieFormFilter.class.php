<?php

/**
 * categorie filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasecategorieFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'parent_id'              => new sfWidgetFormFilterInput(),
      'article_categorie_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'article_categorie')),
    ));

    $this->setValidators(array(
      'parent_id'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'article_categorie_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'article_categorie', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('categorie_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addArticleCategorieListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.article_categorie article_categorie')
          ->andWhereIn('article_categorie.id', $values);
  }

  public function getModelName()
  {
    return 'categorie';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'parent_id'              => 'Number',
      'article_categorie_list' => 'ManyKey',
    );
  }
}
