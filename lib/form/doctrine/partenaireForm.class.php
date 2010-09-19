<?php

/**
 * partenaire form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class partenaireForm extends BasepartenaireForm {
    private $programmes_list;
    
    public function configure() {
	unset($this['created_at'], $this['updated_at']);

	$this->validatorSchema['url'] = new sfValidatorUrl();

	$this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable(array(
			'label' => 'Logo',
			'file_src'  => '/uploads/partenaire/'.$this->getObject()->getLogo(),
			'is_image'  => true,
			'edit_mode' => !$this->isNew(),
			'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
	));



	$this->validatorSchema['logo'] = new sfValidatorFile(array(
			'required'   => false,
			'path'       => sfConfig::get('sf_upload_dir').'/partenaire',
			'mime_types' => 'web_images',
	));

	$this->widgetSchema['accroche'] = new sfWidgetFormCKEditor(array('jsoptions'=>array(
				'height' 	=> '75px',
				'toolbar'	=> 'Basic'
		)));

	$this->widgetSchema['programmes_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'programme'));
	$this->validatorSchema['programmes_list'] = new sfValidatorDoctrineChoice(array(
			'required' => false,
			'model' => 'programme'
	));
    }

    public function updateDefaultsFromObject() {
	parent::updateDefaultsFromObject();
	$arrayKeysProgrammes = array();
	$collection = Doctrine_Core::getTable('partenaireProgramme')->findByDql('partenaire_id = ?', array($this->object->getId()));
	foreach ($collection as $partenaireProgramme) {
	    $arrayKeysProgrammes[] = $partenaireProgramme->get('programme_id');
	}
	if (isset($this->widgetSchema['programmes_list'])) {
	    $this->setDefault('programmes_list', $arrayKeysProgrammes);
	}
    }

    public function bind(array $taintedValues = null, array $taintedFiles = null) {
	$this->programmes_list = $taintedValues['programmes_list'];
	unset($taintedValues['programmes_list']);
	parent::bind($taintedValues, $taintedFiles);
    }

    protected function doSave($con = null) {
	$this->saveProgrammesList($con);
	parent::doSave($con);
    }

    public function saveProgrammesList($con = null) {
	if (!$this->isValid()) {
	    throw $this->getErrorSchema();
	}

	if (!isset($this->widgetSchema['programmes_list'])) {
	    // somebody has unset this widget
	    return;
	}

	if (null === $con) {
	    $con = $this->getConnection();
	}

	$existing = Doctrine_Core::getTable('programme')->findAll()->getKeys();
	$values = $this->programmes_list;
	if (!is_array($values)) {
	    $values = array();
	}

	Doctrine_Core::getTable('partenaireProgramme')->findByDql('partenaire_id = ?', array($this->object->getId()))->delete();
	foreach ($values as $value) {
	    $partenaireProgramme = new partenaireProgramme();
	    $partenaireProgramme->setPartenaire($this->object);
	    $partenaireProgramme->setProgrammeId($value);
	    $partenaireProgramme->save();
	}

    }
}
