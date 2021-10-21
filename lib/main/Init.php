<?php

namespace Console;

class Init
{
    /**
     * List of existing commands.
     * Commands, their descriptions and definitions are stored in the command_manifest.json file
     *
     * @var mixed
     */
    public $commands;

    /**
     * Defining the entered command, connecting its manifest and initializing the class
     *
     * @param $argv
     * @param $argc
     */
    public function __construct($argv)
    {
        $exec = $argv;
        $this->commands = json_decode(file_get_contents(__DIR__ . '/../command_manifest.json'), true);
        $this->requireCommands();
        if (isset($this->commands[$argv[1]])) {
            unset($exec[0], $exec[1]);
            $parse = new Parse($exec);
            $commandClass = new $this->commands[$argv[1]]['className'](['value' => $argv[1], 'description' => $this->commands[$argv[1]]['description']], $parse->parameters, $parse->arguments);
            $commandClass->init();
        } else {
            echo 'Command Not Registered' . "\n";
        }
    }

    /**
     * Registration of all classes registered in the team manifest
     */
    public function requireCommands()
    {
        foreach ($this->commands as $command) {
            require_once $command['path'];
        }
    }
}