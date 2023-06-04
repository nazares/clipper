<?php

namespace Clipper\Command;

class CommandCall
{
    /** @var string */
    public ?string $command;

    /** @var string */
    public string $subcommand;

    /** @var array */
    public array $args = [];

    /** @var array */
    public array $params = [];

    public function __construct(array $argv)
    {
        $this->args = $argv;
        $this->command = $argv[1] ?? null;
        $this->subcommand = $argv[2] ?? 'default';

        $this->loadParams($argv);
    }

    protected function loadParams(array $args): void
    {
        foreach ($args as $arg) {
            $pair = explode('=', $arg);
            if (count($pair) == 2) {
                $this->params[$pair[0]] = $pair[1];
            }
        }
    }

    public function hasParam($param): bool
    {
        return isset($this->params[$param]);
    }

    public function getParam($param)
    {
        return $this->hasParam($param) ? $this->params[$param] : null;
    }
}
