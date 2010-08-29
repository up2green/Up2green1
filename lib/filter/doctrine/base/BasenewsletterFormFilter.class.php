<?php

/**
 * newsletter filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasenewsletterFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'category_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('category'), 'add_empty' => true)),
      'reply_to'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email_from'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_forced'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'sent_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'category_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('category'), 'column' => 'id')),
      'reply_to'    => new sfValidatorPass(array('required' => false)),
      'email_from'  => new sfValidatorPass(array('required' => false)),
      'is_forced'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'sent_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('newsletter_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'newsletter';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'category_id' => 'ForeignKey',
      'reply_to'    => 'Text',
      'email_from'  => 'Text',
      'is_forced'   => 'Boolean',
      'sent_at'     => 'Date',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
    );
  }
}
