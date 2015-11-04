<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('SmartObject.php');

$smObj  = new SmartObject();
$smObj->setTitle('test')->setSubTitle('test1');
echo $smObj->getTitle();
echo $smObj->getSubTitle();
