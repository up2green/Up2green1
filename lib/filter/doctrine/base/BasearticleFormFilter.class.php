<?php

/**
 * article filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasearticleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'logo'                   => new sfWidgetFormFilterInput(),
      'is_active'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'article_categorie_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'article_categorie')),
    ));

    $this->setValidators(array(
      'logo'                   => new sfValidatorPass(array('required' => false)),
      'is_active'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'article_categorie_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'article_categorie', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('article_filters[%s]');

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
    return 'article';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'logo'                   => 'Text',
      'is_active'              => 'Boolean',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
      'article_categorie_list' => 'ManyKey',
    );
  }
}
