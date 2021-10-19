<?php

namespace Console;

class Init
{
    /**
     * Список существующих команд. Команды, их описания и определения
     * хранятся в файле command_manifest.json
     *
     * @var mixed
     */
    public mixed $commands;

    /**
     * Определение введенной команды, подключение ее манифеста и инициализация класса
     *
     * @param $argv
     * @param $argc
     */
    public function __construct($argv, $argc)
    {
        $exec = $argv;
        $this->commands = json_decode(file_get_contents(__DIR__ . '/../command_manifest.json'), true);
        $this->requireCommands();
        if (isset($this->commands[$argv[1]])) {
            unset($exec[0], $exec[1]);
            $parse = new Parse($exec);
            new $this->commands[$argv[1]]['className'](['value' => $argv[1], 'description' => $this->commands[$argv[1]]['description']], $parse->parameters, $parse->arguments);
        } else {
            echo 'Command Not Registered' . "\n";
        }
    }

    /**
     * Регистрация всех классов, зарегистрированных в манифесте команд
     */
    public function requireCommands()
    {
        foreach ($this->commands as $command) {
            require_once $command['path'];
        }
    }
}