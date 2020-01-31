<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SignupsTest\Domain;

use Signups\Domain\Service;
use Signups\Controller\IndexController;
use Zend\Db\Adapter\Adapter;
use Zend\Stdlib\ArrayUtils;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    protected $adapter;
    protected $service;
    public function setUp() : void
    {
        $config = require __DIR__ . '/../../../../config/autoload/db.local.php';
        $this->adapter = new Adapter($config['service_manager']['services']['db-config']);
        $this->service = new Service($this->adapter);
    }

    public function testServiceHasAdapter()
    {
        $this->assertInstanceOf(Adapter::class, $this->service->getAdapter());
    }

    public function testServiceGetEventInfo()
    {
        $data = $this->service->getEventInfo();
        $this->assertEquals(TRUE, is_array($data));
        $this->assertEquals(TRUE, count($data));
    }
}
