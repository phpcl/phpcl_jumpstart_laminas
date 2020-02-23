<?php
declare(strict_types=1);
namespace Login\Controller;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Form\Form;
class IndexController extends AbstractActionController
{
    protected $fromClass;
    protected $fromConfig;
    protected $fromAnno;
    public function __construct(Form $fromClass, Form $fromConfig, Form $fromAnno)
    {
        $this->fromClass  = $fromClass;
        $this->fromConfig = $fromConfig;
        $this->fromAnno   = $fromAnno;
    }
    public function indexAction()
    {
        return new ViewModel(
            [
                'formFromClass'  => $this->fromClass,
                'formFromConfig' => $this->fromConfig,
                'formFromAnno'   => $this->fromAnno,
            ]
        );
    }
}