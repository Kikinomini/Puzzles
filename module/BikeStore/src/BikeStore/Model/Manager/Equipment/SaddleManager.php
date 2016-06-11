<?php

namespace BikeStore\Model\Manager\Equipment;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\Bicycle;
use BikeStore\Model\Equipment\Saddle;
use BikeStore\Model\Manager\EquipmentManager;

class SaddleManager extends EquipmentManager
{
	public static function resolveSaddleType($saddleType)
	{
		switch($saddleType)
		{
			case Saddle::SADDLE_TYPE_CLASSIC:
			{
				return "Klassisch";
			}
			case Saddle::SADDLE_TYPE_SPORTS:
			{
				return "Sport";
			}
			default:
			{
				return "undefined";
			}
		}
	}

	public static function resolveSaddleMaterial($saddleMaterial)
	{
		switch($saddleMaterial)
		{
			case Saddle::SADDLE_MATERIAL_CARBON:
			{
				return "Karbon";
			}
			case Saddle::SADDLE_MATERIAL_LEATHER:
			{
				return "Leder";
			}
			case Saddle::SADDLE_MATERIAL_LEATHERRETTE:
			{
				return "Kunstleder";
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
	 * @return Saddle
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param object $entity
	 * @return Saddle
	 */
	protected function selectCorrectEntity($entity)
	{
		return parent::selectCorrectEntity($entity);
	}

	/**
	 * @param integer $id
	 * @return Saddle
	 */
	public function getEntityById($id)
	{
		return parent::getEntityById($id);
	}

	public function findPossibleSaddlesForBicycle(Bicycle $bicycle)
	{
		/** @var Saddle[] $array */
		$array = $this->repository->findBy(array(
			"listed" => true,
		), array(
				'price' => 'DESC',
			)
		);
		$saddle = $bicycle->getSaddle();
		if (!in_array($saddle, $array))
		{
			$numberElements = count($array);
			for ($i = 0; $i < $numberElements; $i++)
			{
				if ($array[$i]->getPrice() >= $saddle->getPrice())
				{
					array_splice($array, $i, 0, array($saddle));
					break;
				}
			}
		}
		return $array;
	}
}