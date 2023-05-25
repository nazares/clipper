<?php

namespace Clipper;

class App
{
    protected OutputHelper $output;

    public function __construct()
    {
        $this->output = new OutputHelper();
    }

    public function runCommand(array $argv)
    {
        $name = $argv[1] ?? 'World';
        $this->output->print(sprintf("Hello, %s!", $name));
    }
}
