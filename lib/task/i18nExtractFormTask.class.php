<?php

class i18nExtractFormTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
	  new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('source', null, sfCommandOption::PARAMETER_REQUIRED, 'Source language', 'fr'),
      // add your own options here
    ));

	$this->addArgument('form', sfCommandOption::PARAMETER_REQUIRED, 'Name for the form to translate');

    $this->namespace        = 'i18n';
    $this->name             = 'extract-form';
    $this->briefDescription = 'Extracts the labels from a form';
    $this->detailedDescription = <<<EOF
The [i18n-extract-form|INFO] task extracts the labels from a form class into a XLIFF file.
Call it with:
   for CoolForm.class.php you can extract it using:

  [php symfony i18n-extract-form cool|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $sFormname = ucfirst($arguments['form']).'Form';
    $oForm = new $sFormname(false);
    $labels = $oForm->getWidgetSchema()->getLabels();
    $sfMessageSource = new sfMessageSource_XLIFF(sfConfig::get('sf_app_i18n_dir'));
    $sfMessageSource->setCulture($options['source']);
    $sfMessageSource->load($sFormname);
    $existingMessages = $sfMessageSource->read();
    $aKeys = array_keys($existingMessages);
    $aMessages = array_keys($existingMessages[$aKeys[0]]);
    $unLabeled = array();
    foreach ($labels as $name => $value)
    {
        if (!is_null($value))
        {

            if (!in_array($value,$aMessages))
            {
                $sfMessageSource->append($value);
                $this->logSection('i18n', "Adding: " . $value);
            }
        } else {
            $unLabeled[] = $name;
        }
    }


    // an extra service: generate code for the not yet labeled parts: still a bit buggy
    $unLabeled = array_diff($unLabeled, array("_csrf_token"));
    $unLabeled = array_values($unLabeled);

       $return = "Code for unlabeled fields.:\n";
       foreach ($unLabeled as $label)
       {
           $return .= "\t\"" . '$this->widgetSchema->setLabel("' . $label .'","")'."\n";
       }
  }

}
