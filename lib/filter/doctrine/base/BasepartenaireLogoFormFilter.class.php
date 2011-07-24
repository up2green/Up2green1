<?php

/**
 * partenaireLogo filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasepartenaireLogoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'partenaire_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('partenaire'), 'add_empty' => true)),
      'src'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'href'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'partenaire_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('partenaire'), 'column' => 'id')),
      'src'           => new sfValidatorPass(array('required' => false)),
      'href'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('partenaire_logo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'partenaireLogo';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'partenaire_id' => 'ForeignKey',
      'src'           => 'Text',
      'href'          => 'Text',
    );
  }
}
