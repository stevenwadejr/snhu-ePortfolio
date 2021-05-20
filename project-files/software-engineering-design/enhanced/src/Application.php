<?php

namespace stevenwadejr;

use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends SymfonyApplication
{
    private string $appDir;

    public function __construct(string $appDir)
    {
        $this->appDir = $appDir;
        parent::__construct('Enhancement One: Software Design/Engineering', '1.0.0');
    }

    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->output = $output ? $output : new ConsoleOutput();
        return parent::run($input, $this->output);
    }

    public function getAppDir(): string
    {
        return $this->appDir;
    }
}