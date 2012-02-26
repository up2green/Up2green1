<?php

/**
 * Validator for image size 
 */
class up2gValidatorImage extends sfValidatorFile
{

  /**
   * @param array $options
   * @param array $messages 
   */
  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);

    $this->addOption('minx', false);
    $this->addOption('miny', false);
    $this->addOption('maxx', false);
    $this->addOption('maxy', false);

    $this->addMessage('not_a_image', 'The file is not a image.');
    $this->addMessage('minx', 'Das Bild muss mindestens %minx% Pixel breit sein.');
    $this->addMessage('maxx', 'Das Bild darf maximal %maxx% Pixel breit sein.');
    $this->addMessage('miny', 'Das Bild muss mindestens %miny% Pixel hoch sein.');
    $this->addMessage('maxy', 'Das Bild darf maximal %maxy% Pixel hoch sein.');
  }

  /**
   * Clean values and throw validation exception if datas not fit
   * 
   * @param array $value
   * @return array
   * @throws sfValidatorError 
   */
  protected function doClean($value)
  {
    $validatedFile = parent::doClean($value);

    $imagedata = getimagesize($value['tmp_name']);

    if (!$imagedata) {
      throw new sfValidatorError($this, 'not_a_image');
    }

    $this->checkBound('minx', (int) $imagedata[0], false);
    $this->checkBound('maxx', (int) $imagedata[0], true);
    $this->checkBound('miny', (int) $imagedata[1], false);
    $this->checkBound('maxy', (int) $imagedata[1], true);

    return $validatedFile;
  }

  /**
   * Throw validation exception if the datas not fit the criterias
   *
   * @param string $key
   * @param int $size
   * @param bool $leftGreater
   * 
   * @throws sfValidatorError 
   */
  protected function checkBound($key, $size, $leftGreater = true)
  {
    $hasError = $this->hasOption($key)
      && $this->getOption($key) !== false
      && $size > $this->getOption('maxx')
    ;

    if ($hasError) {
      throw new sfValidatorError($this, 'maxx', array(
        'maxx' => $this->getOption('maxx'),
        'size' => $size
      ));
    }
  }

}