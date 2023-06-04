<?php

declare(strict_types=1);

namespace Clipper;

class Config implements ServiceInterface
{
    /** @var array */
    protected array $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @param string $name
     * @param string $value
     * @return void
     */
    public function __set(string $name, string $value): void
    {
        $this->config[$name] = $value;
    }

    /**
     * @param string $name
     * @return string|null;
     */
    public function __get(string $name): ?string
    {
        return $this->config[$name] ?? null;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function has(string $name): bool
    {
        return isset($this->config[$name]);
    }

    /**
     * @inheritDoc
     */
    public function load(App $app)
    {
        return null;
    }
}
