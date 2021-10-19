<?php
// Подключение необходимых классов для старта
require_once ('lib/main/Init.php');
require_once ('lib/main/Parse.php');
require_once ('lib/main/Command.php');
require_once ('lib/CommandInterface.php');

// Запуск
new \Console\Init($argv, $argc);