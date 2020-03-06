<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\EventInterface;

class Module
{
    const PARAM_LOG = __DIR__ . '/../../../data/param.log';
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function onBootstrap(MvcEvent $e)
    {
        // get the MVC event manager
        $em = $e->getApplication()->getEventManager();
        // attach listener
        $em->attach(MvcEvent::EVENT_DISPATCH, [$this, 'auditTrail'], -1);
        $em->attach('custom-event', [$this, 'passParams'], 1);
    }
    public function auditTrail(MvcEvent $e)
    {
        $auditLog = __DIR__ . '/../../../data/audit.log';
        error_log(date('Y-m-d H:i:s') . ':' . __METHOD__ . "\n", 3, $auditLog);
    }
    public function passParams(EventInterface $e)
    {
        $triggerClass  = $e->getTarget();
        $triggerParams = $e->getParams();
        $message = date('Y-m-d H:i:s') . ':'
                 . __METHOD__
                 . ':CLASS:' . get_class($triggerClass)
                 . ':LINE:' . $triggerParams['line'] . "\n" ;
        error_log($message, 3, self::PARAM_LOG);
    }
}
