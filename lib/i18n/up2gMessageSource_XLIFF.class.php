<?php

/**
 * Extend symfony's class to be able to manage other sourec 
 * language of the xliff
 *
 * @category Lib
 * @package  i18n
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class up2gMessageSource_XLIFF extends sfMessageSource_XLIFF
{
  protected $sourceLanguage = 'EN';

  /**
   * Set the source language
   *
   * @param string $sourceLanguage 
   */
  public function setSourceLanguage($sourceLanguage)
  {
    $this->sourceLanguage = $sourceLanguage;
  }

  /**
   * Return the source language
   *
   * @return string
   */
  public function getSourceLanguage()
  {
    return $this->sourceLanguage;
  }

  /**
   * @see parent
   * @param string $catalogue
   * @return string
   */
  protected function getTemplate($catalogue)
  {
    $date = date('c');

    return <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE xliff PUBLIC "-//XLIFF//DTD XLIFF//EN" "http://www.oasis-open.org/committees/xliff/documents/xliff.dtd" >
<xliff version="1.0">
  <file source-language="{$this->sourceLanguage}" target-language="{$this->culture}" datatype="plaintext" original="$catalogue" date="$date" product-name="$catalogue">
    <header />
    <body>
    </body>
  </file>
</xliff>
EOD;
  }

}
