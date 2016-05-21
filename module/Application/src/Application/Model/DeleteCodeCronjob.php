<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 07.07.2015
 * Time: 21:25
 */

namespace Application\Model;


use Application\Model\Manager\CodeManager;
use Cronjob\Model\Cronjob;
use Zend\ServiceManager\ServiceLocatorInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Cronjob\Model\Repository\CronjobRepository")
 */
class DeleteCodeCronjob extends Cronjob{
    public function __construct()
    {
        parent::__construct();
        $this->className = __CLASS__;
        $this->setIntervalInMinutes(60); //jede Stunde
    }

    /**
     * @param ServiceLocatorInterface $serviceLocatorInterface
     * @return boolean
     */
    protected function doCronjob(ServiceLocatorInterface $serviceLocatorInterface)
    {
        /** @var CodeManager $codeManager */
        $codeManager = $serviceLocatorInterface->get("codeManager");

        $maxAge = $serviceLocatorInterface->get("config");
        $maxAge = $maxAge["systemvariablen"]["maxAlterVonCodes"];
        $codes = $codeManager->getAllEntities();
        /** @var Code $code */
        foreach($codes as $code)
        {
            /** @var \DateTime $createTime */
            $createTime = $code->getErstelldatum();
            $createTime->add(new \DateInterval("P".$maxAge."D"));
            if ($createTime->getTimestamp() < time() && $code->getAction() != "bookReader" && $code->getAction() != "bookbinderExternalReader")
            {
//                $a = 6;
                $codeManager->remove($code);
            }
        }
    }

} 