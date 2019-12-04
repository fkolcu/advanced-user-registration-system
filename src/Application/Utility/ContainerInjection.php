<?php

namespace App\Application\Utility;

use Exception;
use DI\Container;
use DI\ContainerBuilder;

trait ContainerInjection
{
    /**
     * @return Container
     * @throws Exception
     */
    public function getContainer()
    {
        $base = __DIR__ . '/../../../';

        // Instantiate PHP-DI ContainerBuilder
        $containerBuilder = new ContainerBuilder();

        // Build PHP-DI Container instance
        return $containerBuilder->build();
    }
}