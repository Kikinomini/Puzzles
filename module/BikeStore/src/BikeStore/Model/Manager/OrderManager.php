<?php

namespace BikeStore\Model\Manager;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\Order;

class OrderManager extends StandardManager
{
    public function __construct($repository, $entity = null)
    {
        parent::__construct($repository, $entity);
    }
    
    /**
	 * @return Order
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param object $entity
	 * @return Order
	 */
	protected function selectCorrectEntity($entity)
	{
		return parent::selectCorrectEntity($entity);
	}

    /**
     * @param integer $id
     * @return Order
     */
	public function getEntityById($id)
	{
		return parent::getEntityById($id);
	}
}