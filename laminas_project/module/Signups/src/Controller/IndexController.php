<?php
declare(strict_types=1);
namespace Signups\Controller;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    public function eventsAction()
    {
        $year = $this->params()->fromQuery('year', date('Y'));
        $container = $this->getEvent()->getApplication()->getServiceManager();
        $adapter = $container->get('Signups\Service\Adapter');
        $sql = "SELECT * FROM events WHERE event_date >= ? AND event_date < ? ORDER BY event_date";
        $events = $adapter->query($sql, [$year, $year + 1]);
        var_dump($events);
        return new ViewModel(['events' => iterator_to_array($events), 'year' => $year]);
    }
}