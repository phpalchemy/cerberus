<?php
use Alchemy\Component\Cerberus;

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
    //$cerberus->setLocale(array("lang" => "es_ES"));
    $cerberus->init($config);

    if (! $cerberus->userExists("admin")) {
        $user = new Cerberus\Model\User();
        $user->setUsername("admin");
        $user->setPassword("admin");

        $cerberus->register($user);
        echo "User created: " . $user->getUsername() . "<br/>";
    }

    $user = $cerberus->getUser("admin");

    if (! $cerberus->roleExists("SYS-ADMIN")) {
        $role = new Cerberus\Model\Role();
        $role->setName("SYS-ADMIN");
        $cerberus->register($role);
        echo "Role created: " . $role->getName() . "<br/>";
    }

    $role = $cerberus->getRole("SYS-ADMIN");

    $user->addRole($role);
    $user->save();

    // setting permissions
    if (! $cerberus->permissionExists("users-view")) {
        $permission = new Cerberus\Model\Permission();
        $permission->setName("users-view");
        $permission->save();
        echo "Permission created: " . $permission->getName() . "<br/>";
    }
    if (! $cerberus->permissionExists("users-edit")) {
        $permission = new Cerberus\Model\Permission();
        $permission->setName("users-edit");
        $permission->save();
        echo "Permission created: " . $permission->getName() . "<br/>";
    }

    $permission1 = $cerberus->getPermission("users-view");
    $permission2 = $cerberus->getPermission("users-edit");

    $role->addPermission($permission1);
    $role->addPermission($permission2);
    $role->save();

    echo "User updated: " . $user->getUpdateDate()->format('Y-m-d H:i:s') . "<br/>";
    echo "Role Updated: " . $user->getUpdateDate()->format('Y-m-d H:i:s') . "<br/>";

} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
    die;
}