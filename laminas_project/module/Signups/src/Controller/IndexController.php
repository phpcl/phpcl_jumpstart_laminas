<?php
declare(strict_types=1);
namespace Signups\Controller;
use Application\Models\EventsModel;
use Laminas\Db\Adapter\Adapter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
class IndexController extends AbstractActionController
{
    protected $model = NULL;
    public function __construct(EventsModel $model)
    {
        $this->model = $model;
    }
    public function indexAction()
    {
        return new ViewModel();
    }
    /**
     * Note: normally you would inject the needed dependencies into the controller via factory
     * In this example, however, we show you how to access the service container directly
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
     * Does the same thing as `eventsAction()` but uses an injected EventsModel to do the work
     */
    public function eventsUsingTableAction()
    {
        $year      = $this->params()->fromQuery('year', date('Y'));
        $events    = $this->model->findEventsByYear((int) $year);
        $viewModel = new ViewModel(['events' => $events, 'year' => $year]);
        $viewModel->setTemplate('signups/index/events');
        return $viewModel;
    }
}