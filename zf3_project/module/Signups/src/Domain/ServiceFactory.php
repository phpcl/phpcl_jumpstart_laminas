<?php

namespace Signups\Domain;

use Zend\Db\Adapter\Adapter;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Signups\Domain\Service;

class ServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return Service
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // NOTE: db-config is in /config/autoload/db.local.php
        return new Service(new Adapter($container->get('db-config')));
    }
}
