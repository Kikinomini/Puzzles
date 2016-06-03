<?php

namespace BikeStore\Model\Manager\Equipment;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\Equipment\Brake;

class BrakeManager extends StandardManager
{
	public static function resolveBrakeType($brakeType)
	{
		switch($brakeType)
		{
			case Brake::BRAKE_TYPE_BLOCK:
			{
				return "Klotzbremse";
			}
			case Brake::BRAKE_TYPE_DISC:
			{
				return "Scheibenbremse";
			}
			default:
			{
				return "undefined";
			}
		}
	}
	
    public function __construct($repository, $entity = null)
    {
        parent::__construct($repository, $entity);
    }
    
    /**
	 * @return Brake
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param object $entity
	 * @return Brake
	 */
	protected function selectCorrectEntity($entity)
	{
		return parent::selectCorrectEntity($entity);
	}

    /**
     * @param integer $id
     * @return Brake
     */
	public function getEntityById($id)
	{
		return parent::getEntityById($id);
	}
}