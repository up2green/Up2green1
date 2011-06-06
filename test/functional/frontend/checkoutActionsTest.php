<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new myTestFunctional(new sfBrowser());

$user = $browser->getSimpleUser();

$browser->
	info('1 - index')->
	get('/checkout/index')->

	with('request')->begin()->
		isParameter('module', 'checkout')->
		isParameter('action', 'index')->
	end()->

	with('response')->begin()->
		isStatusCode(404)->
	end()->

	info('2 - Checkout credits')->
	get('/checkout/credit')->

	with('request')->begin()->
		isParameter('module', 'checkout')->
		isParameter('action', 'credit')->
	end()->

	with('response')->begin()->
		isStatusCode('200')->
	end()->
	
	info('3 - Checkout coupons')->
	get('/checkout/coupon')->
		    
	with('request')->begin()->
		isParameter('module', 'checkout')->
		isParameter('action', 'coupon')->
	end()->
								    
	with('response')->begin()->
		isStatusCode('200')->
	end()

;
