<?php

require_once(dirname(__FILE__).'/unit.php');
$appConfiguration = ProjectConfiguration::getApplicationConfiguration( 'frontend', 'test', true);
new sfDatabaseManager($appConfiguration);