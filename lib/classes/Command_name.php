<?php

use Console\Command;

class Command_name extends Command
{
    public $command;
    public $arguments;
    public $parameters;

    public function launch()
    {
        echo "Called command: " . $this->command['value'] . "\n\n";
        if (!empty($this->arguments)) {
            $step = 3;
            echo "Arguments:\n";
            foreach ($this->arguments as $argument) {
                echo str_repeat(' ', $step) . "-  $argument\n";
            }
            echo "\n";
        }
        if (!empty($this->parameters)) {
            echo "Options:\n";
            foreach ($this->parameters as $key => $parameter) {
                $step = 3;
                echo str_repeat(' ', $step) . "-  $key\n";
                $step = 9;
                if (is_array($parameter)) {
                    foreach ($parameter as $value) {
                        echo str_repeat(' ', $step) . "-  $value\n";
                    }
                } else {
                    echo str_repeat(' ', $step) . "-  $parameter\n";
                }
            }
            echo "\n";
        }
    }
}