<?php

/*
 * This file is part of the sfPHPUnit2Plugin package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Idea taken from bootstrap/functional.php of the lime bootstrap file
 */


$_test_dir = realpath(dirname(__FILE__).'/../..');
$_root_dir = realpath(dirname(__FILE__).'/../../..');

require_once $_root_dir.'/config/ProjectConfiguration.class.php';

// autoloading does not exist at this point yet, require base classes by hand
$_phpunitPluginDir = dirname(__FILE__).'/../../../plugins/sfPHPUnit2Plugin';
require_once $_phpunitPluginDir.'/lib/test/sfPHPUnitBaseTestCase.class.php';
require_once $_phpunitPluginDir.'/lib/test/sfPHPUnitBaseFunctionalTestCase.class.php';

// remove all cache
sfToolkit::clearDirectory(sfConfig::get('sf_app_cache_dir'));

require_once $_root_dir.'/lib/test/FunctionalTestCase.class.php';
require_once $_root_dir.'/lib/test/FrontendFunctionalTestCase.class.php';
require_once $_root_dir.'/lib/test/BackendFunctionalTestCase.class.php';
