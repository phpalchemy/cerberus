<?php
namespace Alchemy\Component\Cerberus\Session;

class PhpNativeSession extends Session
{
    public function init()
    {
        session_start();
    }

    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function get($name, $default = "")
    {
        return array_key_exists($name, $_SESSION)? $_SESSION[$name]: $default;
    }

    public function teardown()
    {
        session_destroy();
    }
}