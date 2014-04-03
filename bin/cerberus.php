<?php
$homeDir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);

try {
    if (!class_exists('\Alchemy\Component\Cerberus\Console\Cerberus')) {
        if (file_exists($file = __DIR__.'/../../../autoload.php')) {
            $vendorDir = realpath(__DIR__.'/../../../');
            $loader = include $file;
        } elseif (file_exists($file = __DIR__.'/../autoload.php')) {
            $vendorDir = realpath(__DIR__.'/../');
            $loader = include $file;
        } else {
            throw new \Exception("Seems vendors are not installed, please execute: composer.phar install");
        }
    }

    $loader->add("Alchemy", $homeDir . DIRECTORY_SEPARATOR . "src");

    $cerberus = new Alchemy\Component\Cerberus\Console\Cerberus();
    $cerberus->setHomeDir($homeDir);
    $cerberus->setVendorDir($vendorDir);
    $cerberus->run();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}

