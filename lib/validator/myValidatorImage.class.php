<?php

class myValidatorImage extends sfValidatorFile
{
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
  
  protected function doClean($value)
  {
    $validatedFile = parent::doClean($value);  
     
    // check image size
     
    $imagedata=getimagesize($value['tmp_name']);
		     
    if (!$imagedata){
      throw new sfValidatorError($this, 'not_a_image');
    }
    if ($this->hasOption('minx') && $this->getOption('minx')!==false && $imagedata[0] < $this->getOption('minx'))
    {
      throw new sfValidatorError($this, 'minx', array('minx' => $this->getOption('minx'), 'size' => (int) $imagedata[0]));
    }
    if ($this->hasOption('maxx') && $this->getOption('maxx')!==false && $imagedata[0] > $this->getOption('maxx'))
    {
      throw new sfValidatorError($this, 'maxx', array('maxx' => $this->getOption('maxx'), 'size' => (int) $imagedata[0]));
    }
    if ($this->hasOption('miny') && $this->getOption('miny')!==false && $imagedata[1] < $this->getOption('miny'))
    {
      throw new sfValidatorError($this, 'miny', array('miny' => $this->getOption('miny'), 'size' => (int) $imagedata[1]));
    }
   if ($this->hasOption('maxy') && $this->getOption('maxy')!==false && $imagedata[1] > $this->getOption('maxy'))
   {
    throw new sfValidatorError($this, 'maxy', array('maxy' => $this->getOption('maxy'), 'size' => (int) $imagedata[1]));
   }
       
   return $validatedFile;
 }
}