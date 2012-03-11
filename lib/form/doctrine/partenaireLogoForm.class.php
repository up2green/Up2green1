<?php

/**
 * partenaireLogo form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class partenaireLogoForm extends BasepartenaireLogoForm
{

  public function configure()
  {
    unset($this['partenaire_id']);
    $this->widgetSchema['src'] = new sfWidgetFormInputFileEditable(array(
        'file_src'  => '/uploads/partenaire/' . $this->getObject()->getPartenaireId() . '/' . $this->getObject()->getSrc(),
        'is_image'  => true,
        'edit_mode' => !$this->isNew(),
        'template'  => '<div>%file%<br />%input%</div>',
      ));

    $this->widgetSchema['src']->setAttribute('style', 'max-width: 200px;max-height: 200px;');

    $this->validatorSchema['src'] = new sfValidatorFile(array(
        'required'   => false,
        'path'       => sfConfig::get('sf_upload_dir') . '/partenaire/' . $this->getObject()->getPartenaireId(),
        'mime_types' => 'web_images',
      ));

    $this->validatorSchema['href'] = new sfValidatorUrl();
  }
}
