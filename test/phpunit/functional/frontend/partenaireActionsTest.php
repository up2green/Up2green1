<?php

require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

class functional_frontend_partenaireActionsTest extends FunctionalTestCase
{

  public function getApplication()
  {
    return 'frontend';
  }

  public function testDefault()
  {
    $browser = $this->getBrowser();

    $browser->
      get('/partenaire/index')->

      with('request')->begin()->
        isParameter('module', 'partenaire')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('body', '!/This is a temporary page/')->
      end()
    ;
  }

}

