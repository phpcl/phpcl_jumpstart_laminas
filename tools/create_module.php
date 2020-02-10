<?php
// this tool creates a Laminas MVC module

// autoloader
spl_autoload_register(
    function ($class) {
        $fn = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
        require $fn;
    }
);

// set up class for use
use Phpcl\Laminas\ModuleBuilder;

// init vars
$type = '';
$actual = 0;    // actual valid args
$expected = 2;  // expected args

// get base dir and module name from command line
$baseDir = $argv[1] ?? NULL;
$moduleName = $argv[2] ?? NULL;

const ERROR_DIR = 'ERROR: invalid directory path';
const ERROR_MOD = 'ERROR: missing module name';
const ERROR_TYPE = 'ERROR: unable to detect framework type';

// error if dir missing or doesn't exist
if ($baseDir === NULL || !file_exists($baseDir)) {
    echo ERROR_DIR . "\n";
} else {
    define('BASEDIR', $baseDir);
    $actual++;
}

// error if module name missing or doesn't exist
if ($moduleName === NULL || empty($moduleName)) {
    echo ERROR_MOD . "\n";
} else {
    define('MODULE_NAME', ucfirst($moduleName));
    $actual++;
}

if ($actual !== $expected) {
    echo ModuleBuilder::USAGE;
    exit;
}

// pull in config
$config = require __DIR__ . '/config/config.php';

// detect type
foreach ($config as $key => $value) {
    if (file_exists($value['config'])) {
        $type = $key;
        break;
    }
}

// create builder instance
try  {
    $builder = new ModuleBuilder($moduleName, $config[$type]);
    switch ($type) {
        case 'zf3' :
        case 'lam' :
            $builder->buildLamMvcModule();
            break;
        default :
            echo ERROR_TYPE . "\n";
    }
    echo 'SUCCESS: ' . $moduleName . ' created!' . "\n";
} catch (Throwable $t) {
    echo 'Oops ... ' . get_class($t) . ':' . $t->getMessage() . "\n";
    echo $t->getTraceAsString() . "\n";
}
