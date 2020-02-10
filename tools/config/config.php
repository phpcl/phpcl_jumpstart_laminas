<?php
// config for Laminas MVC module creation tool

if (!defined('BASEDIR') || !defined('MODULE_NAME')) {
    throw new Exception('Must define constants BASEDIR and MODULE_NAME');
}

// module template
$moduleName = MODULE_NAME;
$moduleLam = <<<EOT
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
$configLam = <<<EOT
<?php
declare(strict_types=1);
namespace $moduleName;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
return [
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
$controllerLam = <<<EOT
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
$viewLam = <<<EOT
<h1>Index View</h1>
EOT;

// template structure for Laminas MVC or ZF 3 app
$lam = [
    'module' => [
        'template' => $moduleLam,
        'path'  => '/src',
        'filename' => 'Module.php',
    ],
    'config' => [
        'template' => $configLam,
        'path'  => '/config',
        'filename' => 'module.config.php',
    ],
    'controller' => [
        'template' => $controllerLam,
        'path'  => '/src/Controller',
        'filename' => 'IndexController.php',
    ],
    'view' => [
        'template' => $viewLam,
        'path'  => '/view',
        'filename' => 'index.phtml',
    ],
];

return [
    // Laminas MVC, ZF3, ZF2, Mezzio or Expressive
    'lam' => [
        // base directory for the module
        'base' => BASEDIR . '/module/' . $moduleName,
        // name of the file that registers modules
        'config' => BASEDIR . '/config/modules.config.php',
        // function to insert the module name into file named above
        'insert' => function ($contents, $name) { return str_replace('];', '    ' . $name . ",\n];\n", $contents); },
        // templates
        'templates' => $lam,
    ],
    'zf3' => [
        // base directory for the module
        'base' => BASEDIR . '/module/' . $moduleName,
        // name of the file that registers modules
        'config' => BASEDIR . '/config/modules.config.php',
        // function to insert the module name into file named above
        'insert' => function ($contents, $name) { return str_replace('];', '    ' . $name . ",\n", $contents); },
        // templates
        'templates' => $lam,
    ],
    // these types are not ready
    /*
    'zf2' => [
        'config' => BASEDIR . '/config/application.config.php',
        'templates' => NULL,
    ],
    'mez' => [
        'config' => BASEDIR . '/config/config.php',
        'templates' => NULL,
    ],
    'exp' => [
        'config' => BASEDIR . '/config/config.php',
        'templates' => NULL,
    ],
    */
];
