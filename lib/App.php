<?php

namespace Clipper;

class App
{
    public OutputHelper $output;
    protected $registry = [];

    public function __construct()
    {
        $this->output = new OutputHelper();
    }

    public function registerCommand($command, $callback)
    {
        $this->registry[$command] = $callback;
    }

    public function runCommand(array $argv)
    {
        $commandName = $argv[1] ?? 'help';
        $command = $this->registry[$commandName] ?? null;

        if ($command === null) {
            $this->output->print(sprintf("ERROR: Command \"%s\" not found.", $commandName));
            exit;
        }
        call_user_func($command, $argv);
    }
}
