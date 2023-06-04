<?php

namespace App\Command\Version;

use Clipper\Command\CommandController;

class DefaultController extends CommandController
{
    public function handle()
    {
        $name = $this->getApp()->config->version;
        // $name = $this->hasParam('user') ? $this->getParam('user') : 'World';
        $this->getPrinter()->display(sprintf("Hello, %s!", $name));
        // exec("php -S 0.0.0.0:8080");
    }
}
