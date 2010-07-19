<?php

/**
 * category filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasecategoryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'unique_name' => new sfWidgetFormFilterInput(),
      'is_active'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'root_id'     => new sfWidgetFormFilterInput(),
      'lft'         => new sfWidgetFormFilterInput(),
      'rgt'         => new sfWidgetFormFilterInput(),
      'level'       => new sfWidgetFormFilterInput(),
      'liens_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'lien')),
    ));

    $this->setValidators(array(
      'unique_name' => new sfValidatorPass(array('required' => false)),
      'is_active'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'root_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lft'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rgt'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'level'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'liens_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'lien', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addLiensListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.lienCategory lienCategory')
          ->andWhereIn('lienCategory.lien_id', $values);
  }

  public function getModelName()
  {
    return 'category';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'unique_name' => 'Text',
      'is_active'   => 'Boolean',
      'root_id'     => 'Number',
      'lft'         => 'Number',
      'rgt'         => 'Number',
      'level'       => 'Number',
      'liens_list'  => 'ManyKey',
    );
  }
}
