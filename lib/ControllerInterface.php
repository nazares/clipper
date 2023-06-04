<?php

namespace Clipper;

use Clipper\Command\CommandCall;

interface ControllerInterface
{
    /**
     * Called before `run`
     *
     * @param App $app
     * @return void
     */
    public function boot(App $app);

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
