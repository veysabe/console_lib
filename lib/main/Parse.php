<?php

namespace Console;

class Parse
{
    /**
     * Список введенных аргументов
     * @var mixed
     */
    public mixed $arguments;
    /**
     * Список введенных опций (параметров)
     * @var mixed
     */
    public mixed $parameters;

    /**
     * Определение и выполнение функции для парсинга и добавления аргументов/параметров вызова команды
     * @param $exec
     */
    public function __construct($exec)
    {
        foreach ($exec as $item) {
            $func = self::determine($item);
            $this->$func($item);
        }
    }

    /**
     * Определение функции
     * @param $line
     * @return string
     */
    public function determine($line)
    {
        switch ($line[0]) {
            case '{':
                return 'parseArgument';
            case '[':
                return 'parseParameter';
            default:
                return 'addArgument';
        }
    }

    /**
     * Функция добавления аргумента
     * @param $arg
     */
    public function addArgument($arg)
    {
        $this->arguments[] = $arg;
    }

    /**
     * Функция парсинга аргумента
     * @param $line
     */
    public function parseArgument($line)
    {
        $line = substr($line, 1, strlen($line) - 2);
        $this->addArgument($line);
    }

    /**
     * Функция парсинга и добавления параметра
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
        }
        if (isset($this->parameters[$name])) {
            if (is_array($this->parameters[$name])) {
                $this->parameters[$name][] = $value;
            } else {
                $this->parameters[$name] = [
                    $this->parameters[$name],
                    $value
                ];
            }
        } else {
            $this->parameters[$name] = $value;
        }
    }

}