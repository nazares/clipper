<?php

namespace Clipper;

class App
{
    public function runCommand(array $argv)
    {
        $name = $argv[1] ?? 'World';
        echo "Hello $name\n";
    }
}
