<?php

/**
 * Extract labels from form in translations
 *
 * @category Lib
 * @package  Task
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class i18nExtractFormTask extends sfBaseTask
{
  /**
   * @see sfBaseTask 
   */
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('trans-language', null, sfCommandOption::PARAMETER_REQUIRED, 'Translation language', 'en'),
      new sfCommandOption('source-language', null, sfCommandOption::PARAMETER_REQUIRED, 'Source language', 'fr'),
    ));

    $this->addArgument('form', sfCommandOption::PARAMETER_REQUIRED, 'Name for the form to translate');

    $this->namespace = 'i18n';
    $this->name = 'extract-form';
    $this->briefDescription = 'Extracts the labels from a form';
    $this->detailedDescription = <<<EOF
The [i18n-extract-form|INFO] task extracts the labels from a form class into a XLIFF file.
Call it with:
   for CoolForm.class.php you can extract it using:

  [php symfony i18n-extract-form cool|INFO]
EOF;
  }

  /**
   * @see sfBaseTask
   * @param array $arguments
   * @param array $options
   * @throws LogicException 
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection      = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $sFormname = ucfirst($arguments['form']) . 'Form';

    if (!class_exists($sFormname)) {
      throw new LogicException(sprintf("class %s don't exist", $sFormname));
    }

    $oForm  = new $sFormname(false);
    $labels = $oForm->getWidgetSchema()->getLabels();

    $sfMessageSource = new up2gMessageSource_XLIFF(sfConfig::get('sf_app_i18n_dir'));
    $sfMessageSource->setCulture($options['trans-language']);
    $sfMessageSource->setSourceLanguage($options['source-language']);

    $catalogue = $oForm->getWidgetSchema()->getFormFormatter()->getTranslationCatalogue();

    if (empty($catalogue)) {
      $catalogue = $arguments['form'] . '.messages';
    }

    $sfMessageSource->load($catalogue);

    $existingMessages = $sfMessageSource->read();
    $aKeys            = array_keys($existingMessages);
    $aMessages        = !empty($aKeys) ? array_keys($existingMessages[$aKeys[0]]) : array();
    $unLabeled = array();

    foreach ($labels as $name => $value) {
      if (!is_null($value)) {
        if (!in_array($value, $aMessages)) {
          $sfMessageSource->append($value);
          $this->logSection('i18n', "Adding: " . $value);
        }
      } else {
        $unLabeled[] = $name;
      }
    }

    $sfMessageSource->save($catalogue);

    // an extra service: generate code for the not yet labeled parts: still a bit buggy
    $unLabeled = array_diff($unLabeled, array("_csrf_token"));
    $unLabeled = array_values($unLabeled);

    $return = "Code for unlabeled fields.:\n";
    foreach ($unLabeled as $label) {
      $return .= "\t\"" . '$this->widgetSchema->setLabel("' . $label . '","")' . "\n";
    }
  }

}
