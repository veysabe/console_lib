<?php

interface CommandInterface
{
    public function launch();

    public function help();
}