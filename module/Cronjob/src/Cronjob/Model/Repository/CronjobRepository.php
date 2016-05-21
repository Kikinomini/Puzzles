<?php

namespace Cronjob\Model\Repository;

use Application\Model\Repository\StandardRepository;

class CronjobRepository extends StandardRepository
{
    public function findAll($asArray = false)
    {
        if ($asArray == true)
        {
            $query = $this->_em->createQuery("SELECT c.id, c.interval, c.lastTime, c.className FROM Cronjob\Model\Cronjob c");
            return $query->getResult();
        }
        return parent::findAll();
    }
}