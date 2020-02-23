<?php
namespace Login\Forms;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Form\Annotation\AnnotationBuilder;

class FormFromAnnoFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return $requestedName instance
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $builder = new AnnotationBuilder();
        return $builder->createForm(FormFromAnno::class);
    }
}
