<?php

namespace BikeStore\Model\Manager;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\Bicycle;
use BikeStore\Model\Filter\ArticleFilterContainer;

class BicycleManager extends ArticleManager
{
    public function __construct($repository, $entity = null)
    {
        parent::__construct($repository, $entity);
    }

	/**
	 * @return Bicycle
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param object $entity
	 * @return Bicycle
	 */
	protected function selectCorrectEntity($entity)
	{
		return parent::selectCorrectEntity($entity);
	}

    /**
     * @param integer $id
     * @return Bicycle
     */
	public function getEntityById($id)
	{
		return parent::getEntityById($id);
	}

	public function findOneByBicycle(Bicycle $bicycle)
	{
		return $this->findOneBy(array(
			'name' => $bicycle->getName(),
			'price' => $bicycle->getPrice(),
			'quickDescription' => $bicycle->getQuickDescription(),
			'description' => $bicycle->getDescription(),
			'imageName' => $bicycle->getImageName(),
			'colour' => $bicycle->getColour(),

			'saddle' => $bicycle->getSaddle(),
			'saddleBar' => $bicycle->getSaddleBar(),
			'handlebars' => $bicycle->getHandlebars(),
			'bell' => $bicycle->getBell(),
			'frontBrake' => $bicycle->getFrontBrake(),
			'rearBrake' => $bicycle->getRearBrake(),
			'frontCoat' => $bicycle->getFrontCoat(),
			'rearCoat' => $bicycle->getRearCoat(),
			'dynamo' => $bicycle->getDynamo(),
			'frontWheel' => $bicycle->getFrontWheel(),
			'gearShift' => $bicycle->getGearShift(),
			'light' => $bicycle->getLight(),
			'mudGuard' => $bicycle->getMudGuard(),
			'pannierRack' => $bicycle->getPannierRack(),
			'pedal' => $bicycle->getPedal(),
			'rearWheel' => $bicycle->getRearWheel(),
			'frontTube' => $bicycle->getFrontTube(),
			'rearTube' => $bicycle->getRearTube(),
			'frame' => $bicycle->getFrame(),
		));
	}
}