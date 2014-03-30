<?php
use Alchemy\Component\Cerberus\Model;

$rootDir = realpath(__DIR__ . "/../../");
//var_dump($rootDir);

$config = array(
    "db-engine" => "mysql",
    "db-user" => "root",
    "db-password" => "sample",
    "db-host" => "127.0.0.1",
    "db-name" => "cerberus",
);

$loader = include $rootDir."/vendor/autoload.php";

try {

    $cerberus = \Alchemy\Component\Cerberus\Cerberus::getInstance();
    $cerberus->setLocale(array("language" => "es_ES"));
    $cerberus->init($config);

    $user = new Model\User();
    $user->setUsername("erik");
    //$user->setPassword("sample");

    $cerberus->addUser($user);
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
    die;
}