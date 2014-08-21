<?php
	
include dirname(__FILE__).'/../vendor/autoload.php';
include dirname(__FILE__).'/s3.inc.php';

$ext_myme = array('jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png');

if (extension_loaded('newrelic')) { newrelic_set_appname('Resize'); }
