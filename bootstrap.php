<?php

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use DI\Container;
use DI\ContainerBuilder;

require_once __DIR__ . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(require __DIR__ . '/settings.php');


$containerBuilder->addDefinitions([EntityManager::class => function (Container $container): EntityManager {

    $config = Setup::createAnnotationMetadataConfiguration(
        $container->get('settings')['doctrine']['metadata_dirs'],
        $container->get('settings')['doctrine']['dev_mode']
    );

    $config->setMetadataDriverImpl(
        new AnnotationDriver(
            new AnnotationReader,
            $container->get('settings')['doctrine']['metadata_dirs']
        )
    );

    $config->setMetadataCacheImpl(
        new FilesystemCache(
            $container->get('settings')['doctrine']['cache_dir']
        )
    );

    return EntityManager::create(
        $container->get('settings')['doctrine']['connection'],
        $config
    );
}]);

$container = $containerBuilder->build();
return $container;