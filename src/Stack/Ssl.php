<?php

namespace Stack;

use Pimple;
use Stack\Ssl\ContainerConfig;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;

class Ssl implements HttpKernelInterface
{
    private $app;
    private $container;

    public function __construct(HttpKernelInterface $app, array $options = [])
    {
        $this->app = $app;
        $this->container = $this->setupContainer($options);
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        if (!$request->isSecure()) {
            $request->server->set('HTTPS', 1);
        }

        return $this->app->handle($request, $type, $catch);
    }

    private function setupContainer(array $options)
    {
        $container = new Pimple();

        $config = new ContainerConfig();
        $config->process($container);

        foreach ($options as $name => $value) {
            $container[$name] = $value;
        }

        return $container;
    }
}
