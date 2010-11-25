<?php


require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$app = 'frontend';
$env = 'prod';
$debug = false;

if (isset($_SERVER) && is_array($_SERVER) && isset($_SERVER['HTTP_HOST'])) {

	/* on définit l'application : */
	if(preg_match('/admin(.*)/', $_SERVER['HTTP_HOST'])) {
		$app = 'backend';
	}

	/* on définit l'environement : */
	if(preg_match('/(.*)\.smartit\.fr/', $_SERVER['HTTP_HOST'])) {
		$env = 'dev';
		$debug = true;
	}
	
}

$configuration = ProjectConfiguration::getApplicationConfiguration($app, $env, $debug);
sfContext::createInstance($configuration)->dispatch();
