<?php

/**
 * session filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasesessionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'sess_data'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sess_time'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_authenticated'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'last_request_time' => new sfWidgetFormFilterInput(),
      'user_id'           => new sfWidgetFormFilterInput(),
      'app'               => new sfWidgetFormFilterInput(),
      'module'            => new sfWidgetFormFilterInput(),
      'action'            => new sfWidgetFormFilterInput(),
      'is_ajax'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'ip'                => new sfWidgetFormFilterInput(),
      'culture'           => new sfWidgetFormFilterInput(),
      'user_agent'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'sess_data'         => new sfValidatorPass(array('required' => false)),
      'sess_time'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_authenticated'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'last_request_time' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'app'               => new sfValidatorPass(array('required' => false)),
      'module'            => new sfValidatorPass(array('required' => false)),
      'action'            => new sfValidatorPass(array('required' => false)),
      'is_ajax'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'ip'                => new sfValidatorPass(array('required' => false)),
      'culture'           => new sfValidatorPass(array('required' => false)),
      'user_agent'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('session_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'session';
  }

  public function getFields()
  {
    return array(
      'sess_id'           => 'Text',
      'sess_data'         => 'Text',
      'sess_time'         => 'Number',
      'is_authenticated'  => 'Boolean',
      'last_request_time' => 'Number',
      'user_id'           => 'Number',
      'app'               => 'Text',
      'module'            => 'Text',
      'action'            => 'Text',
      'is_ajax'           => 'Boolean',
      'ip'                => 'Text',
      'culture'           => 'Text',
      'user_agent'        => 'Text',
    );
  }
}
