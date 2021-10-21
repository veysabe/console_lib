<?php
// Including all required classes
require_once ('lib/main/Init.php');
require_once ('lib/main/Parse.php');
require_once ('lib/main/Command.php');
require_once ('lib/CommandInterface.php');

// Init
new \Console\Init($argv, $argc);