<?php

namespace Cronjob\Controller;

use Application\Model\Datatable\Column\Column;
use Application\Model\Datatable\Column\HiddenColumn;
use Application\Model\Datatable\Column\RouteConfirmColumn;
use Application\Model\Datatable\Datatable;
use Cronjob\Model\Cronjob;
use Cronjob\Model\Manager\CronjobManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CronjobController extends AbstractActionController
{
    public function doSingleCronjobAction()
    {
        /** @var CronjobManager $cronjobManager */
        $cronjobManager = $this->getServiceLocator()->get("Cronjob.Cronjobmanager");

        $cronjob = $cronjobManager->getEntityById($this->params("cronjobId"));
        if ($cronjob instanceof Cronjob)
        {
            if ($cronjob->run($this->getServiceLocator()))
            {
                $this->flashMessenger()->addSuccessMessage("Cronjob erfolgreich ausgeführt.");
            }
            else
            {
                $this->flashMessenger()->addErrorMessage("Cronjob hat einen Fehler verursacht.");
            }
            $cronjobManager->save($cronjob); //Datenbankupdate
        }
        else
        {
            $this->flashMessenger()->addErrorMessage("Cronjob wurde nicht gefunden.");
        }
        return $this->redirect()->toRoute("cronjob");
    }
	public function indexAction()
    {
        /** @var CronjobManager $cronjobManager */
        $cronjobManager = $this->getServiceLocator()->get("Cronjob.cronjobManager");

        $cronjobs = $cronjobManager->getAllCronjobs();

        $table = new Datatable("cronjobs");

        $dateTime = new \DateTime();
        $content = array();
        /** @var Chapter $chapter */
        foreach ($cronjobs as $cronjob) {
            if ($cronjob->getId() !== NULL) {
                $dateTime->setTimestamp($cronjob->getLastRun()->getTimestamp());
                $dateTime->add(new \DateInterval("PT" . $cronjob->getIntervalInMinutes() . "M"));

                $content[] = array(
                    'Name' => $cronjob->getClassName(),
                    'cronjobId' => $cronjob->getId(),
                    'Interval' => $cronjob->getIntervalInMinutes() . " Minuten",
                    'lastRun' => $cronjob->getLastRun()->format("d.m.Y H:i:s"),
                    'lastSuccessRun' => $cronjob->getLastSuccess()->format("d.m.Y H:i:s"),
                    'Fehler' => $cronjob->getErrorMessage(),
                    "nextRun" => $dateTime->format("d.m.Y H:i:s"),
                    'Aktiv' => ($cronjob->getActive()) ? "aktiv" : "deaktiviert",
                );
            }
        }

        $name = new Column("Name");
	    $table->addColumn($name);

	    $interval = new Column("Interval");
	    $table->addColumn($interval);

        $lastRun = new Column("lastRun");
        $lastRun->setLabel("Letzter versuchter Durchlauf");
        $lastRun->setType("date-german");
        $table->addColumn($lastRun);

        $lastSuccessRun = new Column("lastSuccessRun");
        $lastSuccessRun->setLabel("Letzter erfolgreicher Durchlauf");
        $lastSuccessRun->setType("date-german");
        $table->addColumn($lastSuccessRun);

        $nextRun = new Column("nextRun");
        $nextRun->setLabel("Nächster Durchlauf");
        $nextRun->setType("date-german");
        $table->addColumn($nextRun);

	    $error = new Column("Fehler");
	    $table->addColumn($error);

	    $aktive = new Column("Aktiv");
	    $table->addColumn($aktive);

        $cronjobId = new HiddenColumn("cronjobId");
        $table->addColumn($cronjobId);

        $run = new RouteConfirmColumn("run");
        $run->setRouteName("cronjob/doSingleCronjob");
        $run->setRouteDynamicParams(array('cronjobId' => 'cronjobId'));
        $run->setRouteLabel("Ausführen");
        $run->setConfirmDialogTitleText("Cronjob ausführen");
        $run->setConfirmDialogQuestionText("Möchten Sie den Cronjob wirklich ausführen?");
        $table->addColumn($run);

        $table->setContent($content);

		return new ViewModel(array("datatable" => $table));
	}
    public function doCronjobAction()
    {
        /** @var CronjobManager $cronjobManager */
        $cronjobManager = $this->getServiceLocator()->get("Cronjob.Cronjobmanager");

        $cronjobManager->getAllCronjobs();
        $cronjobManager->doCronjobs();
        $cronjobManager->saveAll();

        $this->layout("layout/allBlank");

        return new ViewModel(array());
    }
}