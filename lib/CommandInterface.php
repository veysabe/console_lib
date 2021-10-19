<?php

interface CommandInterface
{
    public function query();

    public function launch();

    public function help();
}