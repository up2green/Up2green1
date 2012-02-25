<?php

/**
 * Project class for Functional tests in the frontend application
 */
class FrontendFunctionalTestCase extends FunctionalTestCase
{
  /**
   * @see FunctionalTestCase
   * @return string 
   */
  public function getApplication()
  {
    return 'frontend';
  }
}
