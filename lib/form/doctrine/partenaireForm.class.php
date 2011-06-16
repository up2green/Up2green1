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
	
	public static $defaultAttestationPath = '/images/pdf/attestation_empty.png';

	public function configure() {
		
		$this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable(array(
				'file_src'  => '/uploads/partenaire/'.$this->getObject()->getLogo(),
				'is_image'  => true,
				'edit_mode' => !$this->isNew(),
				'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
		));
		
		$attestationPath = $this->getObject()->getAttestation();
		
		$this->widgetSchema['attestation'] = new sfWidgetFormInputFileEditable(array(
				'file_src'  => empty($attestationPath) ? self::$defaultAttestationPath : '/uploads/partenaire/'.$attestationPath,
				'is_image'  => true,
				'edit_mode' => !$this->isNew(),
				'with_delete' => !empty ($attestationPath),
				'template'  => '<div class="attestation-wrapper">%file%</div>%input%<br />%delete% %delete_label%',
		));
		
		$this->widgetSchema['description'] = new sfWidgetFormCKEditor();
		$this->widgetSchema['page'] = new sfWidgetFormCKEditor();
		$this->widgetSchema['programmes_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'programme'));

		$this->validatorSchema['logo'] = new sfValidatorFile(array(
				'required'   => false,
				'path'       => sfConfig::get('sf_upload_dir').'/partenaire',
				'mime_types' => 'web_images',
		));

		$this->validatorSchema['attestation'] = new myValidatorImage(array(
				'max_size'   => 1048576,
				'required'   => false,
				'path'       => sfConfig::get('sf_upload_dir').'/partenaire',
				'mime_types' => 'web_images',
				'minx' => 842,
				'miny' => 595,
				'maxx' => 842,
				'maxy' => 595,
		));
		
		$this->validatorSchema['url'] = new sfValidatorUrl();
		$this->validatorSchema['logo_delete'] = new sfValidatorPass();
		
		if(!empty ($attestationPath)) {
			$this->validatorSchema['attestation_delete'] = new sfValidatorPass();
		}

		$this->widgetSchema['accroche'] = new sfWidgetFormCKEditor(array('jsoptions'=>array(
					'height' 	=> '75px',
					'toolbar'	=> 'Basic'
			)));

		$this->validatorSchema['programmes_list'] = new sfValidatorDoctrineChoice(array(
				'required' => false,
				'model' => 'programme'
		));
		
		$this->removeFields();
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
		if(isset ($taintedValues['programmes_list'])) {
			$this->programmes_list = $taintedValues['programmes_list'];
			unset($taintedValues['programmes_list']);
		}
		
		parent::bind($taintedValues, $taintedFiles);
	}

	protected function doSave($con = null) {
		$this->saveProgrammesList($con);
		parent::doSave($con);
	}
	protected function doClean($con = null) {
		parent::doClean($con);
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
		
	protected function removeFields() {
		unset($this['created_at'], $this['updated_at']);
	}
}
