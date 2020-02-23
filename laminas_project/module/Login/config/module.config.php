<?php
declare(strict_types=1);
namespace Login;

use Laminas\Form\Element;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'login' => [
                'type'    => Segment::class,
                'options' => [
                    // add additional params to "route" key if needed
                    'route'    => '/login[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\IndexControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Forms\FormFromClass::class => Forms\FormFromClassFactory::class,
            Forms\FormFromConfig::class => Forms\FormFromConfigFactory::class,
            Forms\FormFromAnno::class => Forms\FormFromAnnoFactory::class,
        ],
        'services' => [
            'login-form-config' => [
                'elements' => [
                        [
                            'spec' => [
                                'type' => Element\Email::class,
                                'name' => 'email',
                                'options' => ['label' => 'Email'],
                                'attributes' => [
                                    'size' => 40,
                                    'placeholder' => 'Use your email address as a login name'
                                ],
                            ],
                        ],
                        [
                            'spec' => [
                                'type' => Element\Password::class,
                                'name' => 'password',
                                'options' => ['label' => 'Password'],
                                'attributes' => ['size' => 20],
                            ],
                        ],
                        [
                            'spec' => [
                                'type' => Element\Submit::class,
                                'name' => 'submit',
                                'attributes' => ['value' => 'Login'],
                            ],
                        ],
                    ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
];