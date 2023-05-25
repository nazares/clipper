<?php

namespace Clipper;

class CommandRegistry
{
    /** @var array $registry*/
    protected array $registry = [];

    /**
     * CLI command registration
     *
     * @param string $command
     * @param callable $callback
     * @return void
     */
    public function registerCommand(string $command, callable $callback): void
    {
        $this->registry[$command] = $callback;
    }

    /**
     * @param string $command
     * @return callable|null
     */
    public function getCommand(string $command): ?callable
    {
        return $this->registry[$command] ?? null;
    }
}
