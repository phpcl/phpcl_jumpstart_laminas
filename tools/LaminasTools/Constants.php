<?php
// this tool creates a Laminas modules
namespace Phpcl\LaminasTools;

class Constants
{
    const COMPOSER_JSON = 'composer.json';
    const USAGE = 'Usage: php laminas-tool.phar WHAT PATH NAME' . "\n"
                . '    WHAT = module | controller' . "\n"
                . '    PATH = absolute path to base of your project structure' . "\n"
                . '    NAME = name of the new module to create or ' . "\n"
                . '           name of the controller (e.g. "Test\\\Controller\\\ListController")' . "\n";
    const BUILD_WHAT   = ['module','controller'];
    const ERROR_WHAT   = 'ERROR: "WHAT" param needs to be one of %s';
    const ERROR_DIR    = 'ERROR: missing or invalid directory path given';
    const ERROR_MOD    = 'ERROR: missing module name or module structure does not exist';
    const ERROR_CTL    = 'ERROR: missing controller name';
    const ERROR_CTL_NM = 'ERROR: controller name must be in this form: ' . "\n" . '       "Abc\Controller\XyzController" where "Abc" is the module name and "Xyz" is descriptive of the functionality';
    const ERROR_TYPE   = 'ERROR: unable to detect framework type';
    const ERROR_UNABLE = 'ERROR: unable to create %s';
    const ERROR_MSG    = 'ERROR: %s : %s' . PHP_EOL . '%s';
    const SUCCESS_MSG  = 'SUCCESS: %s created!';
    const MOD_CTL_NM   = 'Using "%s" for controller name';
    const MOD_REMINDER = 'You need to run the command "composer dump-autoload" (or "php composer.phar dump-autoload") to have the new module recognized';
}