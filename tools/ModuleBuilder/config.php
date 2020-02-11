<?php
// config for Laminas MVC module creation tool

if (!defined('BASEDIR') || !defined('MODULE_NAME')) {
    throw new Exception('Must define constants BASEDIR and MODULE_NAME');
}

$templates = [];
// module template
$moduleName = MODULE_NAME;
$templates['lam']['module'] = <<<EOT
<?php
declare(strict_types=1);
namespace $moduleName;
class Module
{
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
EOT;

// config file template
$routeName = strtolower($moduleName);
$templates['lam']['config'] = <<<EOT
<?php
declare(strict_types=1);
namespace $moduleName;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
return [
    'router' => [
        'routes' => [
            '$routeName' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/{$routeName}[/:action]',
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
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
];
EOT;

// controller template
$templates['lam']['controller'] = <<<EOT
<?php
declare(strict_types=1);
namespace $moduleName\Controller;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
EOT;

// view template
$templates['lam']['view'] = <<<EOT
<h1>$moduleName Index View</h1>
EOT;

return [
    // Laminas MVC
    'lam' => [
        // base directory for the module
        'base' => BASEDIR . '/module/' . $moduleName,
        // name of the file that registers modules
        'config' => BASEDIR . '/config/modules.config.php',
        // function to insert the module name into file named above
        'insert' => function ($contents, $name) {
            if (strpos($contents, "'$name'") === FALSE)
                $contents = str_replace('];', "    '$name',\n];\n", $contents);
            return $contents;
        },
        // templates
        'templates' => [
            'module' => [
                'template' => $templates['lam']['module'],
                'path'  => '/src',
                'filename' => 'Module.php',
            ],
            'config' => [
                'template' => $templates['lam']['config'],
                'path'  => '/config',
                'filename' => 'module.config.php',
            ],
            'controller' => [
                'template' => $templates['lam']['controller'],
                'path'  => '/src/Controller',
                'filename' => 'IndexController.php',
            ],
            'view' => [
                'template' => $templates['lam']['view'],
                'path'  => '/view/' . strtolower(MODULE_NAME) . '/index',
                'filename' => 'index.phtml',
            ],
        ],
    ],
    // Zend Framework 3
    'zf3' => [
        // base directory for the module
        'base' => BASEDIR . '/module/' . $moduleName,
        // name of the file that registers modules
        'config' => BASEDIR . '/config/modules.config.php',
        // function to insert the module name into file named above
        'insert' => function ($contents, $name) {
            if (strpos($contents, "'$name'") === FALSE)
                $contents = str_replace('];', "    '$name',\n];\n", $contents);
            return $contents;
        },
        // templates
        'templates' => [
            'module' => [
                'template' => $templates['lam']['module'],
                'path'  => '/src',
                'filename' => 'Module.php',
            ],
            'config' => [
                'template' => $templates['lam']['config'],
                'path'  => '/config',
                'filename' => 'module.config.php',
            ],
            'controller' => [
                'template' => $templates['lam']['controller'],
                'path'  => '/src/Controller',
                'filename' => 'IndexController.php',
            ],
            'view' => [
                'template' => $templates['lam']['view'],
                'path'  => '/view/' . strtolower(MODULE_NAME) . '/index',
                'filename' => 'index.phtml',
            ],
        ],
    ],
    // these types are not ready
    /*
    // Zend Framework 3
    'zf2' => [
        'config' => BASEDIR . '/config/application.config.php',
        'templates' => NULL,
    ],
    // Mezzio
    'mez' => [
        'config' => BASEDIR . '/config/config.php',
        'templates' => NULL,
    ],
    // Expressive
    'exp' => [
        'config' => BASEDIR . '/config/config.php',
        'templates' => NULL,
    ],
    */
];
