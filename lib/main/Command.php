<?php

namespace Console;


include 'lib/CommandInterface.php';
use CommandInterface;

abstract class Command implements CommandInterface
{
    public $command;
    public $arguments;
    public $parameters;

    public function __construct($command, $parameters, $arguments)
    {
        $this->command = $command;
        $this->parameters = $parameters;
        $this->arguments = $arguments;
        if (!empty($this->arguments) && in_array('help', $this->arguments)) {
            $this->help();
            die();
        }
        $this->query();
        $this->launch();
    }

    abstract function query();

    abstract function launch();

    public function help()
    {
        $help_text = file_get_contents(__DIR__ . '/../manifests/Help');
        $help_text = str_replace(['#COMMAND_NAME#', '#COMMAND_DESC#'], [$this->command['value'], $this->command['description']], $help_text);
        echo print_r($help_text, true);
    }

}