<?php
namespace Alchemy\Component\Cerberus\Console;

use Alchemy\Config;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Application\Cli\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class Cerberus extends Application
{
    protected $homeDir = "";

    public function __construct()
    {
        defined("DS") || define("DS", DIRECTORY_SEPARATOR);
        defined("NS") || define("NS", "\\");

        $title    = "\n Cerberus Cli. ";
        $version  = "1.0";

        parent::__construct($title, $version);
        $this->setCatchExceptions(true);
    }

    /**
     * @param string $homeDir
     */
    public function setHomeDir($homeDir)
    {
        $this->homeDir = $homeDir;
    }

    /**
     * @return string
     */
    public function getHomeDir()
    {
        return $this->homeDir;
    }

    protected function prepare()
    {
        $config = array("home_dir" => $this->homeDir);
        $helpers  = array();
        $commands = array(
            new \Alchemy\Component\Cerberus\Console\Command\BuildCommand($config)
        );

        $helperSet = $this->getHelperSet();

        foreach ($helpers as $name => $helper) {
            $helperSet->set($helper, $name);
        }

        $this->addCommands($commands);
    }

    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->prepare();
        return parent::run();
    }

    /*** Static Functions ***/

    /**
     * Creates a directory recursively
     * @param  string $strPath path
     * @param  integer $rights right for new directory
     * @throws \RuntimeException
     */
    public static function createDir($strPath, $rights = 0777)
    {
        $folderPath = array($strPath);
        $oldumask = umask(0);

        while (!@is_dir(dirname(end($folderPath)))
            && dirname(end($folderPath)) != "/"
            && dirname(end($folderPath)) != "."
            && dirname(end($folderPath)) != ""
        ) {
            array_push($folderPath, dirname(end($folderPath)));
        }

        while ($parentFolderPath = array_pop($folderPath)) {
            if (!@is_dir($parentFolderPath)) {
                if (!@mkdir($parentFolderPath, $rights)) {
                    throw new \RuntimeException("Runtime Error: Can't create folder: $parentFolderPath");
                }
            }
        }

        umask($oldumask);
    }
}

