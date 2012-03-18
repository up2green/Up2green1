<?php

require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

/**
 * Test Plugins / up2gReforestationPlugin / Modules / Ajax / actions.class.php file
 *
 * @category Test
 * @package  Functional
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class functional_frontend_up2gReforestationAjaxActionsTest extends FrontendFunctionalTestCase
{
  /**
   * Test the index action in ajax w/o parameter
   */
  public function testKml()
  {
    $this->getBrowser()->getAndCheck('up2gReforestationAjax', 'kml', '/plantation/ajax/kml');
  }

  /**
   * Test the programme action w/o parameter
   */
  public function testProgrammeWithoutParameter()
  {
    $this->getBrowser()->getAndCheck('up2gReforestationAjax', 'programme', '/plantation/ajax/programme', 404);
  }

  /**
   * Test the programme action with an invalid parameter
   */
  public function testProgrammeInvalidParameter()
  {
    $this->getBrowser()->getAndCheck('up2gReforestationAjax', 'programme', '/plantation/ajax/programme?programme=NotFound', 404);
  }

  /**
   * Test the programme action with a valid parameter
   */
  public function testProgramme()
  {
    $this->getBrowser()->getAndCheck('up2gReforestationAjax', 'programme', '/plantation/ajax/programme?programme=11');
  }

  /**
   * Test the organisme action w/o parameter
   */
  public function testOrganismeWithoutParameter()
  {
    $this->getBrowser()->getAndCheck('up2gReforestationAjax', 'organisme', '/plantation/ajax/organisme', 404);
  }

  /**
   * Test the organisme action with an invalid parameter
   */
  public function testOrganismeInvalidParameter()
  {
    $this->getBrowser()->getAndCheck('up2gReforestationAjax', 'organisme', '/plantation/ajax/organisme?organisme=NotFound', 404);
  }

  /**
   * Test the organisme action with a valid parameter
   */
  public function testOrganisme()
  {
    $this->getBrowser()->getAndCheck('up2gReforestationAjax', 'organisme', '/plantation/ajax/organisme?organisme=11');
  }
}
