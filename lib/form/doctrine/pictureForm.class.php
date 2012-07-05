<?php

/**
 * picture form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pictureForm extends BasepictureForm
{
  public function configure()
  {
    unset(
      $this['created_at'], $this['updated_at'], $this['gallery_id']
    );

    $this->widgetSchema['src'] = new sfWidgetFormInputFileEditable(
      array(
        'file_src'  => '/uploads/gallery/thumbnail/' . $this->getObject()->getSrc(),
        'is_image'  => true,
        'edit_mode' => !$this->isNew(),
        'template'  => '<div>%file%<br />%input%</div>',
      ),
      array(
        'style' => 'max-width: 200px;max-height: 200px;'
      )
    );

    $this->validatorSchema['src'] = new sfValidatorFile(array(
      'required'   => false,
      'path'       => sfConfig::get('sf_upload_dir') . '/gallery',
      'mime_types' => 'web_images',
    ));

  }
}
