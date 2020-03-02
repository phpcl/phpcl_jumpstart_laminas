<?php
declare(strict_types=1);
namespace Signups\Controller;
use Laminas\Db\Adapter\Adapter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    /**
     * @TODO: figure out why this isn't working!
     */
    public function eventsAction()
    {
        $year      = $this->params()->fromQuery('year', date('Y'));
        $container = $this->getEvent()->getApplication()->getServiceManager();
        $adapter   = $container->get('Application\Service\Adapter');
        $sql       = "SELECT * FROM events WHERE event_date LIKE ? ORDER BY event_date";
        $events    = $adapter->query($sql, Adapter::QUERY_MODE_PREPARE);
        $events->execute([$year . '%']);
        return new ViewModel(['events' => $events, 'year' => $year]);
    }
    /**
     * This works OK
     */
    public function eventsUsingTableAction()
    {
        $year      = $this->params()->fromQuery('year', date('Y'));
        $container = $this->getEvent()->getApplication()->getServiceManager();
        $model     = $container->get('Application\Models\EventsModel');
        $events    = $model->findEventsByYear((int) $year);
        $viewModel = new ViewModel(['events' => $events, 'year' => $year]);
        $viewModel->setTemplate('signups/index/events');
        return $viewModel;
    }
}