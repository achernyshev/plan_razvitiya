<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once('Session.php');

$session = new Session;
// comment next line for testing
//$_SESSION['test'] = false;
var_dump($_SESSION['test']); die;