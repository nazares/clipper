<?php

namespace Clipper;

class App
{
    /** @var OutputHelper $output */
    protected OutputHelper $output;

    /** @var CommandRegistry $commandRegistry */
    protected CommandRegistry $commandRegistry;

    /**
     * App constructor
     *
     * @return void
     * */
    public function __construct()
    {
        $this->output = new OutputHelper();
        $this->commandRegistry = new CommandRegistry();
    }

    /**
     * CLI commad registration
     *
     * @param string $command
     * @param callable $callback
     * @return void
     */
    public function registerCommand(string $command, callable $callback): void
    {
        $this->commandRegistry->registerCommand($command, $callback);
    }

    /**
     * @param array $argv
     * @return void
     */
    public function runCommand(array $argv): void
    {
        $commandName = $argv[1] ?? 'help';
        $command = $this->commandRegistry->getCommand($commandName);

        if ($command === null) {
            $this->output->print(sprintf("ERROR: Command \"%s\" not found.", $commandName));
            exit;
        }
        call_user_func($command, $argv);
    }

    /**
     *
     * @param string $out
     * @return void
     */
    public function print(string $out)
    {
        return $this->output->print($out);
    }
}
