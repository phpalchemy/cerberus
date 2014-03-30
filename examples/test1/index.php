<?php
$rootDir = realpath(__DIR__ . "/../../");
var_dump($rootDir);

$loader = include $rootDir."/vendor/autoload.php";

$cerberus = new \Alchemy\Component\Cerberus\Cerberus();
$cerberus->init();