<?php

namespace App\Command\Serve;

use Clipper\Command\CommandController;
use helpers\Color;

class DefaultController extends CommandController
{
    public function handle()
    {
        $public = $this->getApp()->config->rootPath . '/public';
        echo setColor("\nServer Started", Color::White, Color::Blue);
        echo sprintf("\non %s\n", $public);

        exec("php -S  0.0.0.0:0 -t {$public}");

        echo "Press Ctrl+C to stop the server";
    }
}
