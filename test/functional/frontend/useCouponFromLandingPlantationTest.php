<?php

// init
include(dirname(__FILE__).'/../../bootstrap/functional.php');
$voucher = myTestFunctional::getVoucher();

// tests
$browser = new myTestFunctional(new sfBrowser());
$browser->
	info('1 - Use the voucher on the standard lading')->
	get('/landing/plantation')->

	with('request')->begin()->
		isParameter('module', 'landing')->
		isParameter('action', 'plantation')->
	end()->

	with('response')->begin()->
		isStatusCode(404)->
	end()->

	with('form')->begin()->
		click('Utiliser', array('code' => $voucher->getCode()))->
	end()->
	followRedirect();


