<?php

/**
 * Base project form.
 * 
 * @package    up2green
 * @subpackage form
 * @author     Your name here 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class BaseForm extends sfFormSymfony
{
	public function setup()
  {
		parent::setup();
		sfValidatorBase::setDefaultMessage('invalid', 'Champ invalide.');
		sfValidatorBase::setDefaultMessage('required', 'Champ obligatoire.');
		sfValidatorBase::setDefaultMessage('min_length', '"%value%" est trop court (%min_length% lettres minimum).');
		sfValidatorBase::setDefaultMessage('max_length', '"%value%" est trop long (%max_length% lettres maximum).');
	}
}
