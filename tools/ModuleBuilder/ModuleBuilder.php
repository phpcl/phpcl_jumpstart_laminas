<?php
// this tool creates a Laminas modules
namespace Phpcl\Laminas;

class ModuleBuilder
{
    protected $module;      // name of the module
    protected $config;
    protected $output = '';

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
     * @return string $output + "\n"
     */
    public function getOutput()
    {
        return $this->output . PHP_EOL;
    }
    /**
     * Creates everything needed for a Laminas/ZF3 module
     */
    public function buildLamMvcModule()
    {
        // make base directory for module
        $modBase = $this->config['base'];
        $modBase = str_replace('\\', '/', $modBase);
        if (!file_exists($modBase)) mkdir($modBase);
        // write template contents out to appropriate file
        foreach ($this->config['templates'] as $key => $info) {
            $this->output .= 'Creating structures for ' . $key . "\n";
            $base = $modBase;
            // make base directory for module/provider file
            foreach (explode('/', $info['path']) as $dir) {
                $base = str_replace('//', '/', $base . '/' . $dir);
                if (!file_exists($base)) mkdir($base);
            }
            // write template to file
            $filename = $base . '/' . $info['filename'];
            file_put_contents($filename, $info['template']);
        }
        // inject module into app primary config file
        $this->injectConfig();
        // add module to composer.json autoload key
        $jsonFile = BASEDIR . '/' . self::COMPOSER_JSON;
        $this->injectComposerJson($jsonFile);
    }
    /**
     * Injects module name into primary config file
     *
     */
    public function injectConfig()
    {
        $this->output .= 'Configuring module registration ' . "\n";
        // callback to inject module name into master config file
        $contents = file_get_contents($this->config['config']);
        $contents = $this->config['insert']($contents, $this->module);
        file_put_contents($this->config['config'], $contents);
    }
    /**
     * Injects module namespace into composer.json file
     *
     */
    public function injectComposerJson($jsonFile)
    {
        if (file_exists($jsonFile)) {
            $this->output .= 'Configuring module autoloading ' . "\n";
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