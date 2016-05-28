<?php

namespace BikeStore\Model\Manager;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\Bicycle;

class BicycleManager extends StandardManager
{
    public function __construct($repository, $entity = null)
    {
        parent::__construct($repository, $entity);
    }
    
    /**
	 * @return Bicycle
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param object $entity
	 * @return Bicycle
	 */
	protected function selectCorrectEntity($entity)
	{
		return parent::selectCorrectEntity($entity);
	}

    /**
     * @param integer $id
     * @return Bicycle
     */
	public function getEntityById($id)
	{
		return parent::getEntityById($id);
	}
}