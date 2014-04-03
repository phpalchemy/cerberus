<?php

/**
 * This file is part of the PropelServiceProvider package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Alchemy\Service;

use Alchemy\Application;
use Alchemy\Component\Cerberus\Cerberus;

/**
 * Propel service provider.
 *
 * @author Erik Amaru Ortiz <aortiz.erik@gmail.com>
 */
class CerberusServiceProvider implements ServiceProviderInterface
{
    protected $config = array();

    public function register(Application $app)
    {
        $app["cerberus"] = $app->protect(function() use ($app) {
            if (! class_exists('\Alchemy\Component\Cerberus\Cerberus')) {
                throw new \Exception("Can't register Cerberus, it is not installed or not loaded!");
            }

            $config = $app["config"]->getSection("cerberus");
            if (empty($config)) {
                $config = $app["config"]->getSection("database");
            }
            if (empty($config)) {
                throw new \RuntimeException("Database configuration is missing.");
            }

            $config = self::configure($config);
            $cerberus = new Cerberus($config);
            $cerberus->init();

            return $cerberus;
        });
    }

    public function init(Application $app)
    {
        $app["cerberus"]();
    }

    public static function configure($config)
    {
        $requiredConfig = array("engine", "host", "user", "dbname");

        foreach ($requiredConfig as $keyConf) {
            if (! isset($config[$keyConf]) || empty($config[$keyConf])) {
                throw new \RuntimeException(sprintf(
                    "Database configuration \"%s\" is missing or empty!", $keyConf
                ));
            }
        }

        $config = array(
            "db-engine" => $config["engine"],
            "db-user" => $config["user"],
            "db-password" => $config["password"],
            "db-host" => $config["host"],
            "db-name" => $config["dbname"]
        );

        if (isset($config["port"])) {
            $config["db-port"] = $config["port"];
        }

        return $config;
    }
}
