<?php
namespace Alchemy\Component\Cerberus\Console\Command;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;


/**
 * Task for executing Cerberus build
 *
 * @copyright Copyright 2014 Erik Amaru Ortiz
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @link    http://github.com/phpalchemy/cerberus
 * @since   1.0
 * @version $Revision$
 * @author  Erik Amaru Ortiz <aortiz.erik@gmail.com>
 */
class BuildModelCommand extends Command
{
    protected $config = array();

    public function __construct($config)
    {
        parent::__construct();

        if (! array_key_exists("home_dir", $config)) {
            throw new \Exception("Configuration: home_dir, is missing!");
        }
        if (! array_key_exists("vendor_dir", $config)) {
            throw new \Exception("Configuration: vendor_dir, is missing!");
        }

        $this->config = $config;
        $this->config["schema_dir"] = $this->config["home_dir"] . DS . "schema" . DS . "db";
        $this->config["class_dir"] = $this->config["home_dir"] . DS . "src";

        defined("DS") || define("DS", DIRECTORY_SEPARATOR);
    }

    /**
     * @see Console\Command\Command
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->addOption("vendor-dir", null, InputOption::VALUE_REQUIRED, "Vendor Directory", "")
            ->addOption("db-host", null, InputOption::VALUE_REQUIRED, "Data Base server address", "localhost")
            ->addOption("db-port", null, InputOption::VALUE_REQUIRED, "Server Port", "")
            ->addOption("db-user", null, InputOption::VALUE_REQUIRED, "DB User", "")
            ->addOption("db-password", null, InputOption::VALUE_REQUIRED, "DB User Password", "")
            ->addOption("db-name", null, InputOption::VALUE_REQUIRED, "Data Base name", "")
            ->addOption("db-engine", null, InputOption::VALUE_REQUIRED, "Data Base Engine", "mysql")
            ->setName("build:model")
            //->setAliases(array("build"))
            ->setDescription("Build Cerberus");
    }

    /**
     * @see Console\Command\Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $vendorDir = $this->config["vendor_dir"];
        $propelBin = $vendorDir."/propel/propel/bin/propel";
        $dbEngineConf = $input->getOption("db-engine");
        $dbUser = $input->getOption("db-user");
        $dbPassword = $input->getOption("db-password");
        $dbHost = $input->getOption("db-host");
        $dbPort = $input->getOption("db-port");
        $dbName = $input->getOption("db-name");
        $srcName = "cerberus";
        $commands = array();

        if (! file_exists($propelBin)) {
            throw new \Exception("Can't found Propel, binary, please ensure that propel is properly installed.");
        }

        if (! file_exists($this->config["schema_dir"] . "/schema.xml")) {
            throw new \RuntimeException(sprintf(
                "Cerberus DB schema file is missing!" . PHP_EOL .
                "In directory: %s", $this->config["schema_dir"]
            ));
        }

        //accepted values for db engine
        $dbEngines = array("mysql", "pgsql", "mssql", "oracle", "sqlite");
        // Resolving database platform for propel
        switch ($dbEngineConf) {
            case "mysql": $dbEngine = "MysqlPlatform"; break;
            case "pgsql": $dbEngine = "PgsqlPlatform"; break;
            case "mssql": $dbEngine = "MssqlPlatform"; break;
            case "oracle": $dbEngine = "OraclePlatform"; break;
            case "sqlite": $dbEngine = "SqlitePlatform"; break;
            case "sqlsrv": $dbEngine = "SqlsrvPlatform"; break;

            default: throw new \RuntimeException(sprintf(
                "Missing or invalid database engine on .ini configuration file." . PHP_EOL .
                "Accepted values: [%s]" . PHP_EOL .
                "Given: %s" . PHP_EOL,
                implode("|", $dbEngines),
                $dbEngineConf
            ));
        }


        $schemaDir = $this->config["schema_dir"];
        $classDir = $this->config["class_dir"];

        $commands["model"] = sprintf("%s model:build --input-dir=%s --output-dir=%s", $propelBin, $schemaDir, $classDir);
        $commands["sql  "] = sprintf("%s sql:build --input-dir=%s --output-dir=%s --platform=%s", $propelBin, $schemaDir, $schemaDir, $dbEngine);

//        $output->writeln("Propel input dir: " . $schemaDir);
//        $output->writeln("Propel output class dir: " . $classDir);
//        $output->writeln("Propel output sql dir: " . $schemaDir);

        foreach ($commands as $build => $command) {
            $output->write(sprintf("- Building %s ... ", $build));
            system($command, $stat);
            if ($stat === 0)
                $output->writeln("<info>DONE</info>");
            else
                $output->writeln("<error>FAILED</error>");
        }
    }
}

