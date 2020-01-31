<?php
namespace Signups\Domain;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class Service
{
    const TABLE_NAMES = ['events','hotels','signup','users'];
    protected $tables = [];
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        foreach (self::TABLE_NAMES as $name) {
            $this->tables[$name] = new TableGateway($name, $adapter);
        }
    }
    public function getAdapter()
    {
        return $this->adapter;
    }
    public function getEventInfo()
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from(['e' => 'events'])
               ->join(['h' => 'hotels'], 'e.hotel_id = h.id')
               ->join(['s' => 'signup'], 's.event_id = e.id', ['sid' => 'id'])
               ->order('e.event_date ASC');
        $result = $this->tables['events']->selectWith($select);
        $data = [];
        $eventKey = '';
        $count = 0;
        foreach ($result as $obj) {
            if ($obj->event_key != $eventKey) {
                if ($eventKey) {
                    $row = [];
                    foreach ($obj->getArrayCopy() as $key => $value) {
                        $row[$key] = utf8_encode($value);
                    }
                    $row['count'] = $count;
                    $data[$eventKey] = $row;
                    $count = 0;
                }
                $eventKey = $obj->event_key;
            }
            $count++;
        }
        return $data;
    }
    public function getEventInfoForDatatable()
    {
        $data = [];
        $events = $this->getEventInfo();
        foreach ($events as $key => $row) {
            $data[] = [$row['event_name'],$row['event_date'],$row['hotelName'],$row['city'],$row['country'],$row['count']];
        }
        return $data;
    }
}
