<?php
namespace Alchemy\Component\Cerberus;

use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;
use Alchemy\Component\Cerberus\Model\User;
use Alchemy\Component\Cerberus\Model\Role;
use Alchemy\Component\Cerberus\Model\Permission;
use Alchemy\Component\Cerberus\Model\UserRole;
use Alchemy\Component\Cerberus\Model\RolePermission;

/**
 * Cerberus class
 *
 * @copyright Copyright 2014 Erik Amaru Ortiz
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @link    http://github.com/phpalchemy/cerberus
 * @since   1.0
 * @version $Revision$
 * @author  Erik Amaru Ortiz <aortiz.erik@gmail.com>
 */
class Cerberus
{
    /**
     * @var \Alchemy\Component\Cerberus\Cerberus
     */
    protected static $instance;
    /**
     * @var array
     */
    protected $config = array();
    /**
     * @var string
     */
    protected $homeDir = "";
    /**
     * @var array
     */
    protected $translationsTable = array();

    const CERBERUS_DB_SRC_NAME = "Cerberus";

    /**
     * @return \Alchemy\Component\Cerberus\Cerberus|static
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static;
        }

        return self::$instance;
    }

    public function __construct(array $config = array())
    {
        $this->homeDir = realpath(__DIR__."/../../../../");

        if (! empty($config)) {
            $this->setConfig($config);
        }
    }

    public function setConfig(array $config)
    {
        if (empty($config["db-host"])) throw new \Exception("DB Host configuration missing.");
        if (empty($config["db-engine"])) throw new \Exception("DB Engine configuration missing.");
        if (empty($config["db-user"])) throw new \Exception("DB User configuration missing.");
        if (empty($config["db-password"])) throw new \Exception("DB Password configuration missing.");
        if (empty($config["db-name"])) throw new \Exception("DB Name configuration missing.");

        $this->config = array_merge($this->config, $config);
    }

    public function addUser($data)
    {
        echo _("Invalid data type."); die;

        if (get_class($data) == '\Alchemy\Component\Cerberus\Model\User') {
            $data->save();
        } elseif (is_array($data)){
            $user = new User();
            $user->fromArray($data);
        } else {
            throw new \Exception(_("Invalid data type."));
        }

        $user->save();
    }

    /*
     * Others methods
     */

    public function setLocale(array $localeConf)
    {
        $this->config["locale"] = $localeConf;
    }

    public static function translate($strId)
    {
        $me = self::getInstance();
        return $me->translationsTable[$strId] ? $me->translationsTable[$strId] : $strId;
    }

    public function init(array $config = array())
    {
        session_start();
        $this->setConfig($config);
        $this->initLocale();
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

    protected function initLocale()
    {

        if (isset($this->config["locale"])) {

            if (isset($this->config["locale"]["language"])) {
//                $translationFile = $this->homeDir . "/resources/translations/".$this->config["locale"]["language"].".php";
//                if (file_exists($translationFile)) {
//                    $this->translationsTable = include($translationFile);
//                }

//                if (! function_exists("gettext")){
//                    echo "gettext is not installed\n";
//                } else{
//                    echo "gettext is supported\n";
//                }

                $locale = $this->config["locale"]["language"];
                //var_dump($locale); die;
                putenv("LANG=" . $locale);
                setlocale(LC_ALL, "");

                $domain = "cerberus";
                //var_dump($this->homeDir . "/locale"); die;
                bindtextdomain($domain, $this->homeDir . "/locale");
                //bind_textdomain_codeset($domain, 'UTF-8');

                textdomain($domain);

                echo _("Invalid data type."); die("-end-");
            }
        }
    }
}
