<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("CsvFileReader.php");
require_once("XmlFileReader.php");

/*
$xmlFile = new XmlFileReader();
$xmlFile->open('test_files/xml_test.xml');
echo '<pre>';
echo 'File contents:</br>';
var_dump($xmlFile->getContents());
echo 'File Size: </br>';
var_dump($xmlFile->getFileSize('test_files/xml_test.xml'));
*/

/*
$csvFile = new CsvFileReader();
$csvFile->open('test_files/csv_test.csv');
echo '<pre>';
var_dump($csvFile->getContents());
echo 'File Size: </br>';
var_dump($csvFile->getFileSize('test_files/csv_test.csv'));
*/