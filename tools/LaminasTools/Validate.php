<?php
// this tool creates a Laminas modules
namespace Phpcl\LaminasTools;

class Validate
{

    protected static $what = NULL;
    protected static $baseDir = NULL;
    protected static $moduleName = NULL;
    protected static $controller = NULL;
    protected static $message = NULL;
    protected static $inputs = [];

    /**
     * Returns validated CLI args as an array
     *
     * @return array [$what, $baseDir, $moduleName, $controller]
     */
    public static function getInputs()
    {
        return self::$inputs;
    }
    /**
     * Returns validation messages
     *
     * @return string $message
     */
    public static function getMessage()
    {
        return self::$message;
    }
    /**
     * Validates CLI args
     *
     * @param array $argv
     * @return bool TRUE == valid | FALSE otherwise
     */
    public static function checkInputs($argv)
    {
        // get params from command line
        $what       = $argv[1] ?? '';
        $baseDir    = $argv[2] ?? '';
        $name       = $argv[3] ?? '';

        // init validation vars
        $actual       = 0;    // actual valid args
        $expected     = 3;  // expected args
        $moduleName   = '';
        $controller   = '';
        $ctlNameParts = [];

        // error if $what not on list
        $what = strtolower($what);
        if (!in_array($what, Constants::BUILD_WHAT)) {
            self::$message .= sprintf(Constants::ERROR_WHAT, implode(',', Constants::BUILD_WHAT)) . "\n";
        } else {
            // extract module name
            if ($what == Constants::BUILD_WHAT[1]) {
                $ctlNameParts = explode('\\', $name);
                $moduleName   = $ctlNameParts[0];
                $controller   = trim(array_pop($ctlNameParts));
            } else {
                $moduleName = $name;
            }
            $actual++;
        }

        // if dir missing or doesn't exist, assume __DIR__
        if (empty($baseDir) || !file_exists($baseDir)) {
            self::$message .= Constants::ERROR_DIR . "\n";
        } else {
            $actual++;
        }

        // error if module name missing
        if (empty($moduleName)) {
            self::$message .= Constants::ERROR_MOD . "\n";
        } else {
            $actual++;
        }

        // error if controller name missing
        if ($what == Constants::BUILD_WHAT[1]) {
            $expected++;
            if (empty($controller)) {
                self::$message .= Constants::ERROR_CTL . "\n";
            } else {
                // sanitize controller name
                $controller = ucfirst($controller);
                $controller = str_replace('controller', 'Controller', $controller);
                if ($controller == 'Controller') {
                    self::$message .= Constants::ERROR_CTL_NM . "\n";
                } else {
                    if (substr($controller, -10) != 'Controller') {
                        $controller .= 'Controller';
                    }
                    self::$message .= sprintf(Constants::MOD_CTL_NM, $controller) . "\n";
                    $actual++;
                }
            }
        }

        // store inputs
        self::$inputs = [$what, $baseDir, $moduleName, $controller];
        return ($expected == $actual);
    }
}