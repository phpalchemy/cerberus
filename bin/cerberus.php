<?php
$homeDir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);

try {

    if (! class_exists("Alchemy\\Component\\Cerberus\\Console\\Cerberus")) {
        if (! file_exists($homeDir . DIRECTORY_SEPARATOR . "vendor")) {
            throw new \Exception("Seems vendors are not installed, please execute: composer.phar install");
        }
        $vendorDir = $homeDir . DIRECTORY_SEPARATOR . "vendor";

        $loader = include $vendorDir . DIRECTORY_SEPARATOR . "autoload.php";
        $loader->add("Alchemy", $homeDir . DIRECTORY_SEPARATOR . "src");
    }

    $cerberus = new Alchemy\Component\Cerberus\Console\Cerberus();
    $cerberus->setHomeDir($homeDir);
    $cerberus->run();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}

