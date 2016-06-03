<?php

namespace BikeStore\Model\Manager\Equipment;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\Equipment\GearShift;

class GearShiftManager extends StandardManager
{
	public static function resolveGearShiftType($gearShiftType)
	{
		switch($gearShiftType)
		{
			case GearShift::GEAR_SHIFT_TYPE_CHAIN:
			{
				return "Kettenschaltung";
			}
			case GearShift::GEAR_SHIFT_TYPE_HUB:
			{
				return "Nabenschaltung";
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
	 * @return GearShift
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param object $entity
	 * @return GearShift
	 */
	protected function selectCorrectEntity($entity)
	{
		return parent::selectCorrectEntity($entity);
	}

    /**
     * @param integer $id
     * @return GearShift
     */
	public function getEntityById($id)
	{
		return parent::getEntityById($id);
	}
}