<?php

/**
 * programmeTranslation form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class programmeTranslationForm extends BaseprogrammeTranslationForm
{
  public function configure()
  {
		$this->widgetSchema['accroche'] = new sfWidgetFormCKEditor(array('jsoptions'=>array(
			'height' 	=> '75px',
			'toolbar'	=> 'Basic'
		)));
		$this->widgetSchema['description'] = new sfWidgetFormCKEditor();
  }
}
