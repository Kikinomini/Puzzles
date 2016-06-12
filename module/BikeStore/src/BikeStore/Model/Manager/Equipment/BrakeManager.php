<?php

namespace BikeStore\Model\Manager\Equipment;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\Bicycle;
use BikeStore\Model\Equipment\Brake;
use BikeStore\Model\Manager\EquipmentManager;
use Doctrine\Common\Collections\ArrayCollection;

class BrakeManager extends EquipmentManager
{
	/**
	 * @param Brake $article
	 * @param bool $resolveBrakeType
	 * @return array|void
	 */
	public static function getAsArray($article, $resolveBrakeType = true)
	{
		$array = parent::getAsArray($article);
		if ($resolveBrakeType)
		{
			$array["brakeType"] = self::resolveBrakeType($article->getBrakeType());
		}
		else
		{
			$array["brakeType"] = $article->getBrakeType();
		}
		return $array;
	}


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

	public function findPossibleBrakesForBicycle(Bicycle $bicycle)
	{
		/** @var Brake[] $array */
		$array = $this->repository->findBy(array(
			"listed" => true,
		), array(
				'price' => 'DESC',
			)
		);
		$brake = $bicycle->getFrontBrake();
		if (!in_array($brake, $array))
		{
			$numberElements = count($array);
			for ($i = 0; $i < $numberElements; $i++)
			{
				if ($array[$i]->getPrice() >= $brake->getPrice())
				{
					array_splice($array, $i, 0, array($brake));
					break;
				}
			}
		}
		$brake = $bicycle->getRearBrake();
		if (!in_array($brake, $array))
		{
			$numberElements = count($array);
			for ($i = 0; $i < $numberElements; $i++)
			{
				if ($array[$i]->getPrice() >= $brake->getPrice())
				{
					array_splice($array, $i, 0, array($brake));
					break;
				}
			}
		}
		return $array;
	}
}