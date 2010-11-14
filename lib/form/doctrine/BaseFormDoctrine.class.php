<?php

/**
 * Project form base class.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormBaseTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class BaseFormDoctrine extends sfFormDoctrine
{
  public function setup()
  {
	sfValidatorBase::setDefaultMessage('invalid', 'Champ invalide.');
	sfValidatorBase::setDefaultMessage('required', 'Champ obligatoire.');
	sfValidatorBase::setDefaultMessage('min_length', '"%value%" est trop court (%min_length% lettres minimum).');

	parent::setup();
  }
}
