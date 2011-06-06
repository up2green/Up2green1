<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new myTestFunctional(new sfBrowser());

$browser->
	get('/newsletter/index')->

	isForwardedTo('sfGuardAuth', 'signin')->

	// log in
	with('form')->begin()->
		click('Se connecter', array(
			'signin' => array(
				'username' => myTestFunctional::$admin['username'],
				'password' => myTestFunctional::$admin['password']
			)))->
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
