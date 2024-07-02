<?php

namespace Clipper;

use Clipper\Command\CommandCall;
use Clipper\Command\CommandRegistry;
use Clipper\Output\CliPrinter;

class Console
{
    /** @var  string  */
    protected $appSignature;

    /** @var  array */
    protected $services = [];

    /** @var array  */
    protected $loadedServices = [];

    public function __construct(array $config = null)
    {
        $config = array_merge([
            'appPath' => "{$config['rootPath']}/console/Command",
            'theme'    => 'regular',
        ], $config);

        $this->setSignature('./clipper help');

        $this->addService('config', new Config($config));
        $this->addService('commandRegistry', new CommandRegistry($this->config->appPath));
        $this->addService('printer', new CliPrinter());
    }

    /**
     * Magic method implements lazy loading for services.
     * @param string $name
     * @return ServiceInterface|null
     */
    public function __get($name)
    {
        if (!array_key_exists($name, $this->services)) {
            return null;
        }

        if (!array_key_exists($name, $this->loadedServices)) {
            $this->loadService($name);
        }

        return $this->services[$name];
    }

    /**
     * @param string $name
     * @param ServiceInterface $service
     */
    public function addService($name, ServiceInterface $service)
    {
        $this->services[$name] = $service;
    }

    /**
     * @param string $name
     */
    public function loadService($name)
    {
        $this->loadedServices[$name] = $this->services[$name]->load($this);
    }

    /**
     * @return OutputInterface
     */
    public function getPrinter()
    {
        return $this->printer;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->appSignature;
    }

    /**
     * @return void
     */
    public function printSignature()
    {
        $this->getPrinter()->display(sprintf("usage: %s", $this->getSignature()));
    }
    /**
     * @param string $appSignature
     */
    public function setSignature($appSignature)
    {
        $this->appSignature = $appSignature;
    }

    /**
     * @param string $name
     * @param callable $callable
     */
    public function registerCommand($name, $callable)
    {
        $this->commandRegistry->registerCommand($name, $callable);
    }

    /**
     * @param array $argv
     */
    public function runCommand(array $argv = [])
    {
        $input = new CommandCall($argv);

        if (count($input->args) < 2) {
            $this->printSignature();
            exit;
        }

        $controller = $this->commandRegistry->getCallableController($input->command, $input->subcommand);

        if ($controller instanceof ControllerInterface) {
            $controller->boot($this);
            $controller->run($input);
            $controller->teardown();
            exit;
        }

        $this->runSingle($input);
    }

    /**
     * @param CommandCall $input
     */
    protected function runSingle(CommandCall $input)
    {
        try {
            $callback = $this->commandRegistry->getCallback($input->command);
            call_user_func($callback, $input);
        } catch (\Exception $e) {
            $this->getPrinter()->display("ERROR: " . $e->getMessage());
            $this->printSignature();
            exit;
        }
    }
}
