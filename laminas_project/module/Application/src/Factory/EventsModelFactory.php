<?php
namespace Application\Factory;

// use Psr\Container\ContainerInterface;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Application\Models\EventsModel;

class EventsModelFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return EventsModel
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new EventsModel($container->get('Application\Service\Adapter'));
    }
}
