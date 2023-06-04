<?php

namespace Clipper;

interface OutputInterface
{
    public function out(string $message);
    public function newline();
    public function display(string $message): void;
}
