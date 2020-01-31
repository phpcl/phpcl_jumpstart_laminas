<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Signups\Controller;

use Zend\View\Model\ {ViewModel,JsonModel};

class IndexController extends BaseController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    public function ajaxAction()
    {
        $events = $this->service->getEventInfoForDatatable();
        return new JsonModel(['data' => $events]);
    }
}
