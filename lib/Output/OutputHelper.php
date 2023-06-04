<?php

namespace Clipper\Output;

class OutputHelper
{
    /**
     * @param string $message
     * @return void
     */
    public function print(string ...$message): void
    {
        echo sprintf("%s\n\n", ...$message);
    }
}
