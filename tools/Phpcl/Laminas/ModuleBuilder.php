<?php
// this tool creates a Laminas modules
namespace Phpcl\Laminas;

class ModuleBuilder
{
    protected $module;      // name of the module
    protected $config;

    const COMPOSER_JSON = 'composer.json';
    const USAGE = 'Usage: php create_module.php PATH MODULE' . "\n"
                . '    PATH = absolute path to base of your project structure' . "\n"
                . '    MODULE = name of the new module to create' . "\n";

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
     * Creates everything needed for a Laminas/ZF3 module
     */
    public function buildLamMvcModule()
    {
        $modBase = $this->config['base'];
        // make base directory for module
        mkdir($modBase);
        // write template contents out to appropriate file
        foreach ($this->config['templates'] as $key => $info) {
            echo 'Creating structures for ' . $key . "\n";
            $dir = $modBase . $info['path'];
            // make base directory for module/provider file
            mkdir($dir);
            // write template to file
            $filename = $dir . '/' . $info['filename'];
            file_put_contents($filename, $info['template']);
        }
        echo 'Configuring module registration ' . "\n";
        // callback to inject module name into master config file
        $contents = file_get_contents($this->config['config']);
        $contents = $this->config['insert']($contents, $this->module);
        file_put_contents($this->config['config'], $contents);
        // add module to composer.json autoload key
        $jsonFile = BASEDIR . '/' . self::COMPOSER_JSON;
        if (file_exists($jsonFile)) {
            echo 'Configuring module autoloading ' . "\n";
            // backup file
            copy($jsonFile, $jsonFile . '.bak');
            // build source path
            $path = str_replace(
                [BASEDIR, '//'],
                ['', '/'],
                $this->config['base'] . '/' . $this->config['templates']['module']['path'] . '/');
            if ($path[0] == '/') $path = substr($path, 1);
            // add to module source autoload::psr-4
            $json = json_decode(file_get_contents($jsonFile), TRUE);
            $json['autoload']['psr-4'][$this->module . '\\'] = $path;
            // write back to composer.json
            file_put_contents($jsonFile, json_encode($json, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
        }
    }
}