<?php
namespace Alchemy\Component\Cerberus\Common;

class Internationalize
{
    protected static $instance;
    protected $translationsTable = array();

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public static function setLocale($locale)
    {
        $code = $locale['language'];
        $me = self::getInstance();

        if (! file_exists(__DIR__."/../translations/$code.php")) {
           throw new \Exception("There are not translations for lang. code: $code");
        }

        $translationsTable = include(__DIR__."/../translations/$code.php");
        $me->translationsTable = $translationsTable;
    }

    public static function translate()
    {
        $me = self::getInstance();
        $params = func_get_args();
        $text = $params[0];
        $params[0] = array_key_exists($text, $me->translationsTable)? $me->translationsTable[$text]: $text;
        $newText = call_user_func_array('sprintf', $params);

        return $newText;
    }
}