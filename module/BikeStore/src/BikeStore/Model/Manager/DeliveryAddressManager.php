<?php

namespace BikeStore\Model\Manager;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\DeliveryAddress;

class DeliveryAddressManager extends StandardManager
{
    public function __construct($repository, $entity = null)
    {
        parent::__construct($repository, $entity);
    }
    
    /**
	 * @return DeliveryAddress
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param object $entity
	 * @return DeliveryAddress
	 */
	protected function selectCorrectEntity($entity)
	{
		return parent::selectCorrectEntity($entity);
	}

    /**
     * @param integer $id
     * @return DeliveryAddress
     */
	public function getEntityById($id)
	{
		return parent::getEntityById($id);
	}
}