<?php

class SendNewsletterToForm extends BaseForm
{

  public function configure()
  {
    // email
    $this->widgetSchema['email'] = new sfWidgetFormInputText();
    $this->validatorSchema['email'] = new sfValidatorEmail(array(
      'required' => 'true'
      ));

    // vars
    $this->embedForm('newsletterVars', new NewsletterVarCollectionForm(null, array(
      'size' => 5,
    )));
    
    $this->widgetSchema->setNameFormat('sendNewsletterTo[%s]');
  }

  public function getName()
  {
    return 'sendNewsletterTo';
  }

}