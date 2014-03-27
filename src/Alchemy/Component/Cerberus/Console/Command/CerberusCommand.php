<?php
namespace Alchemy\Console\Command;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

use Alchemy\Config;

/**
 * Task for executing projects serve
 *
 * @copyright Copyright 2012 Erik Amaru Ortiz
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @link    www.phpalchemy.org
 * @since   1.0
 * @version $Revision$
 * @author  Erik Amaru Ortiz <aortiz.erik@gmail.com>
 */
class ServeCommand extends Command
{
    protected $config = null;

    public function __construct(Config $config)
    {
//        $this->config = $config;
        parent::__construct();

        defined('DS') || define('DS', DIRECTORY_SEPARATOR);
    }

    /**
     * @see Console\Command\Command
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->addOption('host', null, InputOption::VALUE_REQUIRED, 'Data Base server address', "")
            ->addOption('port', null, InputOption::VALUE_REQUIRED, 'Server Port', "")
            ->addOption('user', null, InputOption::VALUE_REQUIRED, 'DB User', "")
            ->addOption('password', null, InputOption::VALUE_REQUIRED, 'DB User Password', "")
            ->addOption('dbname', null, InputOption::VALUE_REQUIRED, 'Data Base name', "")
            ->setName('init')
            ->setAliases(array('init'))
            ->setDescription('Init Cerberus');
    }

    /**
     * @see Console\Command\Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }


}

