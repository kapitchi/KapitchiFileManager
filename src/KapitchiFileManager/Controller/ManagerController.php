<?php

namespace KapitchiFileManager\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

class ManagerController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
