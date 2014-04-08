<?php
namespace Alchemy\Component\Cerberus;

use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;
use Alchemy\Component\Cerberus\Model\User;
use Alchemy\Component\Cerberus\Model\UserQuery;
use Alchemy\Component\Cerberus\Model\Role;
use Alchemy\Component\Cerberus\Model\RoleQuery;
use Alchemy\Component\Cerberus\Model\Permission;
use Alchemy\Component\Cerberus\Model\PermissionQuery;
use Alchemy\Component\Cerberus\Model\UserRole;
use Alchemy\Component\Cerberus\Model\UserRoleQuery;
use Alchemy\Component\Cerberus\Model\RolePermission;
use Alchemy\Component\Cerberus\Model\RolePermissionQuery;
use Alchemy\Component\Cerberus\Model\LoginLog;
use Alchemy\Component\Cerberus\Model\LoginLogQuery;

use Alchemy\Component\Cerberus\Session;

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
     * @var \Alchemy\Component\Cerberus\Session\Session
     */
    protected $session;

    const CERBERUS_DB_SRC_NAME = "cerberus";

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
        if (! empty($config)) {
            $this->setConfig($config);
        }
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
            if (isset($this->config["locale"]["lang"])) {
                if (! function_exists("gettext")) {
                    error_log("Can't Internationalize Cerberus gettext(), is not loaded.");
                    return false;
                }

                $domain = "cerberus";
                $locale = $this->config["locale"]["lang"];

                putenv("LANG=" . $locale);
                putenv("LC_ALL=" . $locale);
                setlocale(LC_MESSAGES, $locale);
                setlocale(LC_ALL, $locale);
                bindtextdomain($domain, $this->homeDir . "/locale");
                bind_textdomain_codeset($domain, 'UTF-8');
                textdomain($domain);
            }
        }
    }

    /**
     * @param $username
     * @return \Alchemy\Component\Cerberus\Model\User
     */
    public function getUser($username)
    {
        return UserQuery::create()->findOneByUsername($username);
    }

    /**
     * @param $username
     * @return bool
     */
    public function userExists($username)
    {
        return is_object(UserQuery::create()->findOneByUsername($username));
    }

    /**
     * @param $name
     * @return \Alchemy\Component\Cerberus\Model\Role
     */
    public function getRole($name)
    {
        return RoleQuery::create()->findOneByName($name);
    }

    /**
     * @param $name
     * @return bool
     */
    public function roleExists($name)
    {
        return is_object(RoleQuery::create()->findOneByName($name));
    }

    /**
     * @param $name
     * @return \Alchemy\Component\Cerberus\Model\Permission
     */
    public function getPermission($name)
    {
        return PermissionQuery::create()->findOneByName($name);
    }

    /**
     * @param $name
     * @return bool
     */
    public function permissionExists($name)
    {
        return is_object(PermissionQuery::create()->findOneByName($name));
    }

    public function authenticate($username, $password)
    {
        $user = $this->getUser($username);

        if (! is_object($user)) {
            throw new \Exception(sprintf(_("Invalid User, the user \"%s\" is not registered!"), $username));
        }

        if ($user->getStatus() !== "ACTIVE") {
            throw new \Exception(sprintf(_("The user \"%s\" is not active."), $username));
        }

        if (! $user->authenticate($password)) {
            throw new \Exception(_("Authentication failed."));
        }

        $log = new LoginLog();
        $log->setType("LOGIN");
        $log->setDateTime(date("Y-m-d H:i:s"));
        $log->setUsername($username);
        $log->setUserId($user->getId());

        if (isset($_SERVER["HTTP_HOST"])) {
            $log->setClientAddress($_SERVER["HTTP_HOST"]);
        }
        if (isset($_SERVER["REMOTE_ADDR"])) {
            $log->setClientIp($_SERVER["REMOTE_ADDR"]);
        }
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            if(ini_get("browscap")) {
                $browser = get_browser(null, true);
            } else {
                $browser = self::getBrowser();
            }

            $log->setClientAgent($browser["browser"]." (v".$browser["version"].")");
            $log->setClientPlatform($browser["platform"]);
        }
        if (session_status() === PHP_SESSION_ACTIVE) {
            $log->setSessionId(session_id());
        }
        $log->save();

        return $user;
    }

    public function initUserSession(User $user)
    {
        $this->session = new Session\PhpNativeSession();
        $this->session->init();
        $this->session->set("user", $user);
        $this->session->set("user_id", $user->getId());

        /** @var \Alchemy\Component\Cerberus\Model\Role[] $roles */
        $rolesCollection = $user->getRoles();
        $roles = array();
        $rolesList = array();
        $permissions = array();
        $permissionsList = array();

        foreach ($rolesCollection as $role) {
            $roles[] = $role;
            $rolesList[] = $role->getName();
            $permissionsCollection = $role->getPermissions();

            foreach ($permissionsCollection as $permission) {
                $permissions[] = $permission;
                $permissionsList[] = $permission->getName();
            }
        }

        $this->session->set("user.roles", $roles);
        $this->session->set("user.roles_list", $rolesList);
        $this->session->set("user.permissions", $permissions);
        $this->session->set("user.permissions_list", $permissionsList);
    }

    public function userCanAccess($permissionName)
    {
        if (is_subclass_of($this->session, 'Alchemy\Component\Cerberus\Session\Session')) {
            return in_array($permissionName, $this->session->get("user.permissions_list", array()));
        }

        return false;
    }

    public function getUserRoles()
    {
        return $this->session->get("user.roles");
    }

    public function getUserPermissions()
    {
        return $this->session->get("user.permissions");
    }

    public static function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
        $ub = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the user agent yes separately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }
        elseif(preg_match('/Firefox/i',$u_agent))
        {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }
        elseif(preg_match('/Chrome/i',$u_agent))
        {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }
        elseif(preg_match('/Safari/i',$u_agent))
        {
            $bname = 'Apple Safari';
            $ub = "Safari";
        }
        elseif(preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Opera';
            $ub = "Opera";
        }
        elseif(preg_match('/Netscape/i',$u_agent))
        {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }

        // check if we have a number
        if ($version==null || $version=="") {$version="?";}

        return array(
            'userAgent' => $u_agent,
            'browser'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }
}


