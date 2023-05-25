<?php

namespace Clipper;

class OutputHelper
{
    public function print($message): void
    {
        echo sprintf("%s\n\n", $message);
    }
}
