<?php
namespace Signups\Factory;
// for future use:
// use Psr\Container\ContainerInterface;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Db\Adapter\Adapter;
class AdapterFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName, array $options = null) {
        return new Adapter($container->get('local-db-config'));
    }
}
