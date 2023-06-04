<?php

namespace Clipper\Output;

class CliTheme
{
    public $styles = [];

    public function __construct(array $styles)
    {
        $this->styles = $styles;
    }

    public function __get($name): ?array
    {
        return $this->styles[$name] ?? null;
    }
}
