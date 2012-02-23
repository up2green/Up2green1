<?php

require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

class functional_frontend_blogActionsTest extends FunctionalTestCase
{

  public function getApplication()
  {
    return 'frontend';
  }

  public function testDefault()
  {
    $this->markTestIncomplete('TODO');
    
//    $browser = $this->getBrowser();
//
//    $browser->
//      get('/blog/index')->
//
//      with('request')->begin()->
//        isParameter('module', 'blog')->
//        isParameter('action', 'index')->
//      end()->
//
//      with('response')->begin()->
//        isStatusCode(200)->
//        checkElement('body', '!/This is a temporary page/')->
//      end()
//    ;
//     
  }

}
