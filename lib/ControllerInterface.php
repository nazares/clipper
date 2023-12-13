<?php

namespace Clipper;

use Clipper\Command\CommandCall;

interface ControllerInterface
{
    /**
     * Called before `run`
     *
     * @param Console $console
     * @return void
     */
    public function boot(Console $console);

    /**
     * Main execution
     *
     * @param CommandCall $input
     * @return void
     */
    public function run(CommandCall $input);

    /**
     * Called after `run` is successfunlly finished
     *
     * @return void
     */
    public function teardown();
}
