<?php
namespace Application\Models;

use Laminas\Db\Sql\Where;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGateway;

class EventsModel
{
    const TABLE_NAME = 'events';
    protected $gateway = NULL;
    public function __construct(AdapterInterface $adapter)
    {
        $this->gateway = new TableGateway(self::TABLE_NAME, $adapter);
    }
    public function findEventsByYear(int $year)
    {
        $where = new Where();
        $where->like('event_date', $year . '%');
        return $this->gateway->select($where);
    }
}
