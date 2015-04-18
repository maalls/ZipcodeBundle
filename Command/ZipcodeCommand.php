<?php

// src/AppBundle/Command/GreetCommand.php
namespace Maalls\ZipcodeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ZipcodeCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('zipcode:find')
            ->setDescription('Find info related to a zipcode.')
            ->addArgument(
                'zipcode',
                InputArgument::REQUIRED,
                'zipcode'
            )
            ->addArgument(
                'country',
                InputArgument::REQUIRED,
                'country'    
            )
            /*->addOption(
                'verbose',
                null,
                InputOption::VALUE_NONE,
                'Output the log.'
            )*/
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $zipcode = $this->getContainer()->get("maalls.zipcode");
        
        $info = $zipcode->zipcode($input->getArgument("zipcode"), $input->getArgument("country"));
        
        $output->writeln(json_encode($info));

    }
}

class DebugLog {

    private $output;
    private $loggers;

    public function __construct($output) {

        $this->output = $output;

    }

    public function addLogger($logger)
    {

        $this->loggers[] = $logger;

    }

    public function log($msg, $level = "info") {

        $this->output->writeln(date("Y-m-d H:i:s") . " " . $level . " " . $msg);

        foreach($this->loggers as $logger) {

            $logger->log($msg, $level);

        }

    }

}