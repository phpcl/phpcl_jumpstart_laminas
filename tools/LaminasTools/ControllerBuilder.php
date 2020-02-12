<?php
// this tool creates a Laminas modules
namespace Phpcl\LaminasTools;

class ControllerBuilder
{
    protected $module;      // name of the module that hosts the new controller
    protected $controller;  // name of the controller to build
    protected $config;
    protected $output = '';

    /**
     * @param string $module == name of the module to be created
     * @param array $config == templates and how to inject module into list of modules for this app
     */
    public function __construct(string $module, array $config)
    {
        $this->module = $module;
        $this->config = $config;
    }
    /**
     * @return string $output + "\n"
     */
    public function getOutput()
    {
        return $this->output . PHP_EOL;
    }
    /**
     * Creates everything needed for a Laminas/ZF3 controller
     *
     * @param string $baseDir == absolute path to project base
     * @param string $moduleName == name of module to build
     * @param string $controller == name of controller to build
     */
    public function buildLamMvcController(string $baseDir, string $moduleName, string $controller)
    {

        // create "short" names
        $ctlShort = strtolower(substr($controller, 0, -10));
        $modShort = strtolower($moduleName);

        // make base directory for controller
        $this->output .= 'Creating directory structures for new controller' . "\n";
        $ctlBase = $this->config['base'];

        // make sure mod structure exists
        if (!file_exists($ctlBase)) {
            $this->output .= Constants::ERROR_MOD . "\n";
            return FALSE;
        }

        // build controller base directory structure (if it doesn't exist)
        $dirs    = explode('/', $this->config['templates']['controller']['path']);
        foreach ($dirs as $dir) {
            $ctlBase = str_replace('//', '/', $ctlBase . '/' . $dir);
            if (!file_exists($ctlBase)) mkdir($ctlBase);
        }

        // get controller template
        $contents = $this->config['templates']['controller']['template'];
        // replace "IndexController" with $controller
        $contents = str_replace('IndexController', $controller, $contents);
        // write template contents out to appropriate file
        $this->output .= 'Writing out new controller file' . "\n";
        file_put_contents(str_replace('//', '/', $ctlBase . '/' . $controller . '.php'), $contents);

        // create view template
        $this->output .= 'Creating view template' . "\n";
        $viewPath = str_replace('\\\\', '/', $this->config['templates']['view']['path']);
        $viewDirs = explode('/', $viewPath);
        array_pop($viewDirs);
        array_push($viewDirs, $ctlShort);
        $viewPath = $this->config['base'] . '/' . implode('/', $viewDirs);
        $viewPath = str_replace('//', '/', $viewPath);
        if (!file_exists($viewPath)) mkdir($viewPath);

        // write out view template
        $viewFile = $viewPath . '/' . $this->config['templates']['view']['filename'];
        $viewFile = str_replace('//', '/', $viewFile);
        $contents = $this->config['templates']['view']['template'];
        $contents = str_replace('IndexController', $controller, $contents);
        file_put_contents($viewFile, $contents);

        // update module config file
        $this->output .= 'Backing up module config file' . "\n";
        $modConf = $this->config['base']
                 . '/' . $this->config['templates']['config']['path']
                 . '/' . $this->config['templates']['config']['filename'];
        $modConf = str_replace('//', '/', $modConf);
        copy($modConf, $modConf . '.bak');
        $this->output .= 'Updating module config file' . "\n";
        $contents = file_get_contents($modConf);
        // add ref to InvokableFactory if not found
        if (strpos($contents, 'InvokableFactory') === FALSE) {
            $this->output .= 'Adding "use Laminas\ServiceManager\Factory\InvokableFactory;"' . "\n";
            str_replace(
                'return',
                'use Laminas\ServiceManager\Factory\InvokableFactory;' . PHP_EOL . 'return',
                $contents
            );
        }

        // inject controller registration
        $this->output .= 'Assigning new controller to "InvokableFactory"' . "\n";
        $text = '            Controller\\' . $controller . '::class => InvokableFactory::class,';
        $contents = $this->injectConfig('controllers', 'factories', $text, $contents);

        // inject route
        $newRoute = '/' . $modShort . '-' . $ctlShort;
        $this->output .= sprintf('Adding route for new controller: %s', $newRoute) . "\n";
        $text = $this->config['templates']['route']['template'];
        $text = str_replace('%%SHORT_NAME%%', $ctlShort, $text);
        $text = str_replace('IndexController', $controller, $text);
        $contents = $this->injectConfig('router', 'routes', $text, $contents);

        // write out new config file
        return file_put_contents($modConf, $contents);
    }
    /**
     * Injects module name into primary config file
     *
     * @param string $topKey = primary array key to search for
     * @param string $subKey = secondary array key to search for
     * @param string $text   = text to insert
     * @param string $contents = original contents
     * @return string $contents = modified contents
     */
    public function injectConfig(string $topKey, string $subKey, string $text, string $contents)
    {
        $pos = strpos($contents, $topKey);
        $pos = strpos($contents, $subKey, $pos);
        if (strpos($contents, 'array(', $pos) !== FALSE) {
            $pos = strpos($contents, 'array(', $pos);
        } else {
            $pos = strpos($contents, '[', $pos);
        }
        $contents = substr($contents, 0, $pos + 1)
                  . PHP_EOL
                  . $text
                  . substr($contents, $pos + 1);
        return $contents;
    }
}