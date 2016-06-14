<?php

namespace BikeStore\Model\Manager\Equipment;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\Equipment\Frame;

class FrameManager extends StandardManager
{
	public static function resolveRiderType($riderType)
	{
		switch($riderType)
		{
			case Frame::RIDER_TYPE_MALE:
			{
				return "Männerfahrrad";
			}
			case Frame::RIDER_TYPE_CHILD:
			{
				return "Kinderfahrrad";
			}
			case Frame::RIDER_TYPE_FEMALE:
			{
				return "Frauenfahrrad";
			}
			default:
			{
				return "undefined";
			}
		}
	}

	public static function resolveBikeType($bikeType)
	{
		switch($bikeType)
		{
			case Frame::BIKE_TYPE_CITY:
			{
				return "Cityfahrrad";
			}
			case Frame::BIKE_TYPE_EBIKE:
			{
				return "E-Fahrrad";
			}
			case Frame::BIKE_TYPE_MOUNTAIN:
			{
				return "Mountainbike";
			}
			case Frame::BIKE_TYPE_RACER:
			{
				return "Rennrad";
			}
			case Frame::BIKE_TYPE_TOURING:
			{
				return "Trekkingrad";
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
	 * @return Frame
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param object $entity
	 * @return Frame
	 */
	protected function selectCorrectEntity($entity)
	{
		return parent::selectCorrectEntity($entity);
	}

    /**
     * @param integer $id
     * @return Frame
     */
	public function getEntityById($id)
	{
		return parent::getEntityById($id);
	}
}