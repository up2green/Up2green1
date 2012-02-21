<?php

class BasePhpunitTestSuite extends sfBasePhpunitTestSuite
  implements sfPhpunitContextInitilizerInterface
{
  /**
   * Dev hook for custom "setUp" stuff
   */
  protected function _start()
  {
    $this->_initFilters();
  }

  /**
   * Dev hook for custom "tearDown" stuff
   */
  protected function _end()
  {
  }

  protected function _initFilters36()
  {
    $filters = sfConfig::get('sf_phpunit_filter', array());
    $codeCoverageFilter = new PHP_CodeCoverage_Filter();
    
    foreach ($filters as $filter) {
      $codeCoverageFilter->addDirectoryToBlacklist($filter['path']);
    }
  }

  protected function _initFilters()
  {
    if (version_compare(PHPUnit_Runner_Version::id(), '3.6') >= 0) {
      $this->_initFilters36();
      exit;
    }
    
    $filters = sfConfig::get('sf_phpunit_filter', array());
    
    foreach ($filters as $filter) {
      
      if (version_compare(PHPUnit_Runner_Version::id(), '3.5') >= 0) {
        PHP_CodeCoverage_Filter::getInstance()->addDirectoryToBlacklist($filter['path']);
      } else {
        PHPUnit_Util_Filter::addDirectoryToFilter($filter['path'], $filter['ext']);
      }

    }

  }

  public function getApplication()
  {
    return 'frontend';
  }
}