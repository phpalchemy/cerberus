<?php
use Alchemy\Component\Cerberus;

$rootDir = realpath(__DIR__ . "/../../");

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
        $user->setPassword("example-password");
        $user->save();

        echo "User created: " . $user->getUsername() . "<br/>";
    }

    $user = $cerberus->getUser("admin");

    if (! $cerberus->roleExists("SYS-ADMIN")) {
        $role = new Cerberus\Model\Role();
        $role->setName("SYS-ADMIN");
        $role->save();

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

    // authenticate a user by its password
    $me = $cerberus->getUser("admin");
    $password = "example-password";
    $result = $me->authenticate($password) ? "Yes" : "No";

    echo "User Authenticated: " . $result . "<br/>";

    // authenticate a user with Cerberus

    try {
        $cerberus->authenticate("erik", $password);
    } catch (\Exception $e) {
        echo $e->getMessage() . "<br/>";
    }

    try {
        $cerberus->authenticate("admin", "example");
    } catch (\Exception $e) {
        echo $e->getMessage() . "<br/>";
    }

    $result = $cerberus->authenticate("admin", $password) ? "Yes" : "No";

    echo "User Authenticated: " . $result . "<br/>";

    $cerberus->initUserSession($user);

    echo "User logged Id: " . $_SESSION["user_id"] . "<br/>";
    echo "User logged Name: " . $_SESSION["user"]->getUsername() . "<br/>";
    echo "User logged Roles List: ";
    var_dump($_SESSION["user.roles_list"]);
    //var_dump($cerberus->getUserRoles());
    echo "User logged Permissions List: ";
    var_dump($_SESSION["user.permissions_list"]);
    //var_dump($cerberus->getUserPermissions());

    // verifying access to a resource
    echo "User permission verifying: invalid";
    var_dump($cerberus->userCanAccess("invalid-permission"));

    echo "User permission verifying: valid";
    var_dump($cerberus->userCanAccess("users-edit"));

} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
    die;
}


