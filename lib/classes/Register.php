<?php

use Console\Command;

class Register extends Command
{
    public function query()
    {
    }

    public function launch()
    {
        $com_manifest = json_decode(file_get_contents(__DIR__ . '/../command_manifest.json'), true);
        if (json_last_error()) {
            echo "Error occurred while opening command manifest file" . "\n";
            die();
        }
        $com_name = $this->parameters['name'] ?? false;
        $com_desc = $this->parameters['description'] ?? false;
        if (isset($com_manifest[$com_name])) {
            echo "Command Is Already Registered" . "\n";
            die();
        }
        if (!$com_name) {
            echo "Name is required" . "\n";
            die();
        }
        $className = ucfirst($com_name);
        $classPath = "classes/$className.php";
        $manifest = file_get_contents(__DIR__ . '/../manifests/NewCommandClass.lock');
        $manifest = str_replace('#CLASS_NAME#', $className, $manifest);
        $com_manifest[$com_name] = [
            "className" => $className,
            "description" => $com_desc,
            "path" => "lib/$classPath"
        ];
        $json = json_encode($com_manifest);
        if (json_last_error()) {
            echo "Error occurred while editing command manifest file" . "\n";
            die();
        }
        file_put_contents(__DIR__ . "/../$classPath", $manifest);
        file_put_contents(__DIR__ . '/../command_manifest.json', $json);
        echo "Command Was Registered Successfully" . "\n";
    }
}