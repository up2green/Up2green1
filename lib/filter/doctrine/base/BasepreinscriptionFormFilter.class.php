<?php

/**
 * preinscription filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasepreinscriptionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'first_name'    => new sfWidgetFormFilterInput(),
      'last_name'     => new sfWidgetFormFilterInput(),
      'email_address' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'username'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'first_name'    => new sfValidatorPass(array('required' => false)),
      'last_name'     => new sfValidatorPass(array('required' => false)),
      'email_address' => new sfValidatorPass(array('required' => false)),
      'username'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('preinscription_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'preinscription';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'first_name'    => 'Text',
      'last_name'     => 'Text',
      'email_address' => 'Text',
      'username'      => 'Text',
    );
  }
}
