<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());

$browser
	->getAndCheck('default', 'error404', '/default/error404', 404)

	->get('/truc/Introuvable')
	->with('response')
	->begin()
	->isStatusCode(404)
	->end()
;
