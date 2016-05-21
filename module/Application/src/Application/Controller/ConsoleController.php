<?php

namespace Application\Controller;

use Application\Model\FormBuilder;
use Zend\Console\Request;
use Zend\Mvc\Controller\AbstractActionController;

class ConsoleController extends AbstractActionController{

    public function indexAction()
    {
        echo "erfolgreich IndexAction aufgerufen!";
    }

    public function addFormAction()
    {
        $request = $this->getRequest();
        if ($request instanceof Request) {

            $module = $request->getParam("module");
            $entity = $request->getParam("entity");

            $formBuilder = new FormBuilder();

            $formBuilder->setObject($module, $entity);

            if (!file_exists("Form/Hydrator"))
            {
                mkdir("Form/Hydrator", 0777, true);
//                throw new \Exception("Directorys !");
            }
            if (!file_exists("Form/InputFilter"))
            {
                mkdir("Form/InputFilter", 0777, true);
//                throw new \Exception("Directorys !");
            }
            file_put_contents("Form/".$formBuilder->getFormName().".php", $formBuilder->createForm());
            echo "Form erfolgreich erstellt.\n";
            file_put_contents("Form/Hydrator/".$formBuilder->getHydratorName().".php", $formBuilder->createHydrator());
            echo "Hydrator erfolgreich erstellt.\n";
        }
    }
} 