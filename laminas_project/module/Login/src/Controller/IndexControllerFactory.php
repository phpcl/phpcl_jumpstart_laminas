<?php

namespace Login\Controller;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Login\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return IndexController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new IndexController(
            $container->get(\Login\Forms\FormFromClass::class),
            $container->get(\Login\Forms\FormFromConfig::class),
            $container->get(\Login\Forms\FormFromAnno::class)
        );
    }
}
