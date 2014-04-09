<?php
namespace Alchemy\Component\Cerberus\Session;

class PhpNativeSession extends Session
{
    protected $sid;

    public function __construct()
    {
        $this->init();
        $this->sid = session_id();
    }

    public function init()
    {
        session_start();
    }

    public function teardown()
    {
        session_destroy();
    }

    public function getSid()
    {
        return $this->sid;
    }

    public function isOpen()
    {
        return session_id() != "";
    }

    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function get($name, $default = "")
    {
        return isset($_SESSION[$name])? $_SESSION[$name]: $default;
    }
}