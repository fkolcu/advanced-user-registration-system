<?php

namespace App\Application\Utility;

use DI\Container;

trait ContainerInjection
{
    public function getContainer()
    {
        $base = __DIR__ . '/../../../';

        /** @var Container $containerEntity */
        return require_once $base . 'bootstrap.php';
    }
}