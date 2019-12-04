<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Persistence\User\UserRepository;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepositoryInterface::class => \DI\autowire(UserRepository::class),
    ]);
};