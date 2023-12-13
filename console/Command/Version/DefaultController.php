<?php

namespace Console\Command\Version;

use Clipper\Command\CommandController;

class DefaultController extends CommandController
{
    public function handle()
    {
        $name = $this->getApp()->config->version;
        $this->getPrinter()->display(sprintf("CLIpper %s", $name));
        // exec("php -S 0.0.0.0:8080");
    }
}
