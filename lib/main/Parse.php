<?php

namespace Console;

class Parse
{
    /**
     * List of arguments
     * @var mixed
     */
    public $arguments;
    /**
     * List of options (parameters)
     * @var mixed
     */
    public $parameters;

    /**
     * Defining and executing a function for parsing and adding arguments/parameters
     * @param $exec
     */
    public function __construct($exec)
    {
        foreach ($exec as $item) {
            $func = self::determine($item);
            if ($func) {
                $this->$func($item);
            }
        }
    }

    /**
     * Function Determine
     * @param $line
     * @return string
     */
    public function determine($line)
    {
        switch ($line[0]) {
            case '{':
                if ($line[strlen($line) - 1] == '}') {
                    return 'parseArgument';
                } else {
                    return false;
                }
            case '[':
                if ($line[strlen($line) - 1] == ']') {
                    return 'parseParameter';
                } else {
                    return false;
                }
            default:
                return false;
        }
    }

    /**
     * Argument adding function
     * @param $arg
     */
    public function addArgument($arg)
    {
        $this->arguments[] = $arg;
    }

    /**
     * Argument parsing function
     * @param $line
     */
    public function parseArgument($line)
    {
        $line = substr($line, 1, strlen($line) - 2);
        $this->addArgument($line);
    }

    /**
     * Parameter parsing and adding function
     * @param $line
     */
    public function parseParameter($line)
    {
        $line = substr($line, 1, strlen($line) - 2);
        $tmp = explode('=', $line);
        $name = $tmp[0];
        $value = $tmp[1];
        if ($value[0] == '{' && $value[strlen($value) - 1] == '}') {
            $value = substr($value, 1, strlen($value) - 2);
            if (stristr($value, ',')) {
                $value = explode(',', $value);
            }
        }
        if (isset($this->parameters[$name])) {
            if (is_array($this->parameters[$name])) {
                if (is_array($value)) {
                    $this->parameters[$name] += $value;
                } else {
                    $this->parameters[$name][] = $value;
                }
            } else {
                if (is_array($value)) {
                    $this->parameters[$name] = [
                        $this->parameters[$name]
                    ];
                    $this->parameters[$name] += $value;
                } else {
                    $this->parameters[$name] = [
                        $this->parameters[$name],
                        $value
                    ];
                }
            }
        } else {
            $this->parameters[$name] = $value;
        }
    }

}