<?php

namespace Clipper;

interface ServiceInterface
{
    /**
     * Loads components
     *
     * @param Console $console
     * @return void
     */
    public function load(Console $console);
}
