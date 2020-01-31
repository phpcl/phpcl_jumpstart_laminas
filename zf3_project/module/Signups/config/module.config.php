<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Signups;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'signups' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/signups[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    // NOTE: db-config is in /config/autoload/db.local.php
    'service_manager' => [
        'factories' => [
            Domain\Service::class => Domain\ServiceFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\BaseControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'strategies' => ['ViewJsonStrategy'],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
