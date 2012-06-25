<?php

/**
 * picture filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasepictureFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'gallery_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Gallery'), 'add_empty' => true)),
      'src'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'gallery_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Gallery'), 'column' => 'id')),
      'src'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('picture_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'picture';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'gallery_id' => 'ForeignKey',
      'src'        => 'Text',
    );
  }
}
