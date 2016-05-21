<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 18.03.2016
 * Time: 23:25
 */

namespace Application\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Stdlib\ResponseInterface as Response;

class AjaxSettingsController extends AbstractActionController{
    public function onDispatch(MvcEvent $e)
    {
        $this->layout("layout/ajax");
        return parent::onDispatch($e);
    }
}