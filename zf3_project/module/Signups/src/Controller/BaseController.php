<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Signups\Controller;

use Signups\Domain\Service;
use Zend\Mvc\Controller\AbstractActionController;

abstract class BaseController extends AbstractActionController
{
    protected $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function getService()
    {
        return $this->service;
    }
}
