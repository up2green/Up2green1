<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());

$browser->
	get('/newsletter/index')->

	isForwardedTo('sfGuardAuth', 'signin')->

	// log in
	with('form')->begin()->
		click('Se connecter', array(
			'signin' => array(
				'username' => 'admin',
				'password' => 'up2g@dm1n')))->
	end()->

	followRedirect()->

	with('request')->begin()->
		isParameter('module', 'newsletter')->
		isParameter('action', 'index')->
	end()->

	with('response')->begin()->
		isStatusCode(200)->
	end()
;
