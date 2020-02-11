<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Application\Service\Calendar;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $cal;
    public function __construct(Calendar $cal)
    {
        $this->cal = $cal;
    }
    public function calendarAction()
    {
        $lang = $this->params()->fromQuery('lang', Calendar::DEFAULT_LANG);
        $year = $this->params()->fromQuery('year', date('Y'));
        $cal = $this->cal->getCalendar($lang, (int) $year);
        return new ViewModel(['cal' => $cal]);
    }
    public function indexAction()
    {
        return new ViewModel();
    }
}
