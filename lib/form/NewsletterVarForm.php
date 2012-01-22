<?php

class NewsletterVarForm extends BaseForm
{

  public function configure()
  {
    // key
    $this->widgetSchema['key'] = new sfWidgetFormInputText();
    $this->validatorSchema['key'] = new sfValidatorPass();

    // value
    $this->widgetSchema['value'] = new sfWidgetFormInputText();
    $this->validatorSchema['value'] = new sfValidatorPass();
  }

  public function getName()
  {
    return 'newsletterVar';
  }

}