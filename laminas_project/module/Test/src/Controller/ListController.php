<?php
declare(strict_types=1);
namespace Test\Controller;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
class ListController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}