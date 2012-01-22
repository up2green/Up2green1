<?php

class NewsletterVarCollectionForm extends BaseForm
{

  public function configure()
  {
    // vars
    for ($i = 0; $i < $this->getOption('size', 5); $i++)
    {
      $form = new NewsletterVarForm();
      $this->embedForm($i, $form);
    }
    
    $this->widgetSchema->setNameFormat('newsletterVarCollection[%s]');
  }

  public function getName()
  {
    return 'newsletterVarCollection';
  }

}