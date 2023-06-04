<?php

namespace Clipper;

interface ServiceInterface
{
    /**
     * Loads components
     *
     * @param App $app
     * @return void
     */
    public function load(App $app);
}
