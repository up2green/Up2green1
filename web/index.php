<?php

if (!isset($_SERVER) || !is_array($_SERVER) || !isset($_SERVER['HTTP_HOST'])) {
	die('service not supported sorry');
}

$app = 'frontend';
$env = 'prod';
$debug = false;

/* on définit l'application : */
if(preg_match('/admin(.*)/', $_SERVER['HTTP_HOST'])) {
	$app = 'backend';
}
elseif(preg_match('/association(.*)/', $_SERVER['HTTP_HOST'])) {
	$separator = '';

	if(empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] === '/') {
		$_SERVER['REQUEST_URI'] = '/blog';
	}
	elseif(substr($_SERVER['REQUEST_URI'], 0, 6) !== '/blog/') {
		$_SERVER['REQUEST_URI'] = '/blog'.$_SERVER['REQUEST_URI'];
	}
}
elseif(preg_match('/reforestation(.*)/', $_SERVER['HTTP_HOST'])) {
	$separator = '';

	if(empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] === '/') {
		$_SERVER['REQUEST_URI'] = '/plantation';
	}
	elseif(substr($_SERVER['REQUEST_URI'], 0, 6) !== '/plantation/') {
		$_SERVER['REQUEST_URI'] = '/plantation'.$_SERVER['REQUEST_URI'];
	}
}

/* on définit l'environement : */
if(preg_match('/(.*)\.smartit\.fr/', $_SERVER['HTTP_HOST'])) {
	$env = 'dev';
	$debug = true;
}

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration($app, $env, $debug);
sfContext::createInstance($configuration)->dispatch();
