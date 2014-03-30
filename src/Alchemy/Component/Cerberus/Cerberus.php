<?php
namespace Alchemy\Component\Cerberus;

use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;

class Cerberus
{
    protected $config;
    const CERBERUS_DB_SRC_NAME = "Cerberus";

    public function __construct(array $config = array())
    {
        empty($config) || $this->config = $config;
    }

    public function init()
    {
        $this->initPropel();
    }

    protected function initPropel()
    {
        $serviceContainer = Propel::getServiceContainer();
        $serviceContainer->setAdapterClass(self::CERBERUS_DB_SRC_NAME, $this->config["db-engine"]);
        $manager = new ConnectionManagerSingle();
        $port = empty($this->config["db-port"])? "": ";port=".$this->config["db-port"];
        $manager->setConfiguration(array(
            "dsn" => $this->config["db-engine"].":host=".$this->config["db-host"].";dbname=".$this->config["db-name"].$port,
            "user"     => $this->config["db-user"],
            "password" => $this->config["db-password"],
        ));
        $serviceContainer->setConnectionManager(self::CERBERUS_DB_SRC_NAME, $manager);
    }
}