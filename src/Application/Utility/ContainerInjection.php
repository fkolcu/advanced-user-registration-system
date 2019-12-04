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
        $path_main = __DIR__ . '/../../../';

        // Instantiate PHP-DI ContainerBuilder
        $containerBuilder = new ContainerBuilder();

        $settings = require $path_main . 'app/settings.php';
        $dependencies = require $path_main . 'app/dependencies.php';

        $settings($containerBuilder);
        $dependencies($containerBuilder);

        // Build PHP-DI Container instance
        return $containerBuilder->build();
    }
}