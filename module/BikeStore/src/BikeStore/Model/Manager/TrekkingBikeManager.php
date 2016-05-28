<?php

namespace BikeStore\Model\Manager;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\TrekkingBike;

class TrekkingBikeManager extends StandardManager
{
    public function __construct($repository, $entity = null)
    {
        parent::__construct($repository, $entity);
    }
    
    /**
	 * @return TrekkingBike
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param object $entity
	 * @return TrekkingBike
	 */
	protected function selectCorrectEntity($entity)
	{
		return parent::selectCorrectEntity($entity);
	}

    /**
     * @param integer $id
     * @return TrekkingBike
     */
	public function getEntityById($id)
	{
		return parent::getEntityById($id);
	}
}