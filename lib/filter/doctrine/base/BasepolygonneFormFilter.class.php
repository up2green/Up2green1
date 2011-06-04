<?php

/**
 * polygonne filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasepolygonneFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'unique_name'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'programmes_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'programme')),
    ));

    $this->setValidators(array(
      'unique_name'     => new sfValidatorPass(array('required' => false)),
      'programmes_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'programme', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('polygonne_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addProgrammesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.programmePolygonne programmePolygonne')
      ->andWhereIn('programmePolygonne.programme_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'polygonne';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'unique_name'     => 'Text',
      'programmes_list' => 'ManyKey',
    );
  }
}
