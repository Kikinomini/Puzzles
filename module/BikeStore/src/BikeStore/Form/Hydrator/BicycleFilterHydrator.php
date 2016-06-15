<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 14.06.16
 * Time: 16:19
 */

namespace BikeStore\Form\Hydrator;

use BikeStore\Model\Filter\BicycleFilterContainer;

class BicycleFilterHydrator extends ArticleFilterHydrator
{
	public function extract($object)
	{
		return parent::extract($object);
	}

	public function hydrate(array $data, $bicycleFilterContainer)
	{
		/** @var BicycleFilterContainer $bicycleFilterContainer */
		$bicycleFilterContainer = parent::hydrate($data, $bicycleFilterContainer);

		isset($data["frameType"]) && $bicycleFilterContainer->setFrameTypes($data["frameType"]);
		isset($data["riderType"]) && $bicycleFilterContainer->setRiderTypes($data["riderType"]);
		isset($data["frameHeightMin"]) && $bicycleFilterContainer->setFrameHeightMin($data["frameHeightMin"]);
		isset($data["frameHeightMax"]) && $bicycleFilterContainer->setFrameHeightMax($data["frameHeightMax"]);

		return $bicycleFilterContainer;
	}
}