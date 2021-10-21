<?php

interface CommandInterface
{
    public function launch();

    public function init();

    public function help();
}