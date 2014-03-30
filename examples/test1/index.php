<?php
$rootDir = realpath(__DIR__ . "/../../");
//var_dump($rootDir);

$config = array(
    "db-user" => "root",
    "db-password" => "sample",
    "db-host" => "127.0.0.1",
    "db-name" => "ctest",
);

$loader = include $rootDir."/vendor/autoload.php";

$cerberus = new \Alchemy\Component\Cerberus\Cerberus();
$cerberus->init($config);

$user = new Alchemy\Component\Cerberus\Model\User();
$user->setUsrUsername("erik");
$user->setUsrPassword("sample");

var_dump($user->getUsrUsername());

//$cerberus->addUser($user);