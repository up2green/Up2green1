<?php

/**
 * module filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasemoduleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'content_id'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'content_type' => new sfWidgetFormChoice(array('choices' => array('' => '', 'categorie' => 'categorie', 'lien' => 'lien', 'article' => 'article', 'newsletter' => 'newsletter', 'programme' => 'programme', 'organisme' => 'organisme', 'gmap' => 'gmap', 'recherche' => 'recherche', 'user' => 'user', 'sgGuardAuth' => 'sgGuardAuth'))),
      'is_active'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'action'       => new sfWidgetFormFilterInput(),
      'user_access'  => new sfWidgetFormFilterInput(),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'content_id'   => new sfValidatorPass(array('required' => false)),
      'content_type' => new sfValidatorChoice(array('required' => false, 'choices' => array('categorie' => 'categorie', 'lien' => 'lien', 'article' => 'article', 'newsletter' => 'newsletter', 'programme' => 'programme', 'organisme' => 'organisme', 'gmap' => 'gmap', 'recherche' => 'recherche', 'user' => 'user', 'sgGuardAuth' => 'sgGuardAuth'))),
      'is_active'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'action'       => new sfValidatorPass(array('required' => false)),
      'user_access'  => new sfValidatorPass(array('required' => false)),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('module_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'module';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'content_id'   => 'Text',
      'content_type' => 'Enum',
      'is_active'    => 'Boolean',
      'action'       => 'Text',
      'user_access'  => 'Text',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
    );
  }
}
