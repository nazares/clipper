<?php

namespace Clipper\Command;

use Clipper\Console;
use Clipper\ControllerInterface;
use Clipper\Output\CliPrinter;

abstract class CommandController implements ControllerInterface
{
    /** @var Console */
    protected Console $app;

    /** @var CommandCall */
    protected CommandCall $input;

    /**
     * Command Logic
     *
     * @return void
     */
    abstract public function handle();

    /** @inheritDoc */
    public function boot(Console $console)
    {
        $this->app = $console;
    }

    /** @inheritDoc */
    public function run(CommandCall $input)
    {
        $this->input = $input;
        $this->handle();
    }

    /** @inheritDoc */
    public function teardown()
    {
        //
    }

    public function getArgs()
    {
        return $this->input->args;
    }

    public function getParams()
    {
        return $this->input->params;
    }

    public function getParam($param)
    {
        return $this->input->getParam($param);
    }

    public function hasParam($param): bool
    {
        return $this->input->hasParam($param);
    }

    /** @return Console */
    public function getApp(): Console
    {
        return $this->app;
    }

    /** @return CliPrinter */
    public function getPrinter(): CliPrinter
    {
        return $this->getApp()->getPrinter();
    }
}
