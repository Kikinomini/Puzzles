<?php

namespace BikeStore\Model\Manager;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\Article;
use BikeStore\Model\Equipment;

class EquipmentManager extends ArticleManager
{
	const BATTERY = "battery";
	const BELL = "bell";
	const BRAKE = "brake";
	const COAT = "coat";
	const DYNAMO = "dynamo";
	const FRAME = "frame";
	const FRONT_WHEEL = "frontwheel";
	const GEAR_SHIFT = "gearshift";
	const HANDLEBARS = "handlebars";
	const LIGHT = "light";
	const MUD_GUARD = "mudguard";
	const PANNIER_RACK = "pannierrack";
	const PEDAL = "pedal";
	const REAR_WHEEL = "rearwheel";
	const SADDLE = "saddle";
	const SADDLE_BAR = "saddlebar";
	const TUBE = "tube";

	/**
	 * @param Article $article
	 * @return array
	 */
	public static function getAsArray($article)
	{
		return parent::getAsArray($article);
	}
	
    public function __construct($repository, $entity = null)
    {
        parent::__construct($repository, $entity);
    }
    
    /**
	 * @return Equipment
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param object $entity
	 * @return Equipment
	 */
	protected function selectCorrectEntity($entity)
	{
		return parent::selectCorrectEntity($entity);
	}

    /**
     * @param integer $id
     * @return Equipment
     */
	public function getEntityById($id)
	{
		return parent::getEntityById($id);
	}
}