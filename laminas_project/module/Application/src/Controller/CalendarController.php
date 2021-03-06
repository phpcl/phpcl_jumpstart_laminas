<?php
declare(strict_types=1);
namespace Application\Controller;
use Application\Service\Calendar;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
class CalendarController extends AbstractActionController
{
    protected $cal;
    public function __construct(Calendar $cal)
    {
        $this->cal = $cal;
    }
    public function indexAction()
    {
        $year = $this->params()->fromQuery('year', date('Y'));
        $cal = $this->cal->getCalendar((int) $year);
        return new ViewModel(['cal' => $cal]);
    }
}
