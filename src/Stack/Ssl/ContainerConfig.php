<?php

namespace Stack\Ssl;

use Pimple;
use Stack\Router;

class ContainerConfig
{
    public function process(Pimple $container)
    {
        $container['router'] = $container->share(function ($container) {
            return new Router($container, $container['routes']);
        });
    }
}
