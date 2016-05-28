<?php

namespace BikeStore\Model\Manager;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\OrderItem;

class OrderItemManager extends StandardManager
{
    public function __construct($repository, $entity = null)
    {
        parent::__construct($repository, $entity);
    }
    
    /**
	 * @return OrderItem
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param object $entity
	 * @return OrderItem
	 */
	protected function selectCorrectEntity($entity)
	{
		return parent::selectCorrectEntity($entity);
	}

    /**
     * @param integer $id
     * @return OrderItem
     */
	public function getEntityById($id)
	{
		return parent::getEntityById($id);
	}
}