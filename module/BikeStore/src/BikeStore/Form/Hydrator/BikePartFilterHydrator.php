<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 08.06.16
 * Time: 13:29
 */

namespace BikeStore\Form\Hydrator;


use BikeStore\Model\Filter\BikePartFilterContainer;

class BikePartFilterHydrator extends ArticleFilterHydrator
{
	/**
	 * @param array $data
	 * @param \BikeStore\Model\Filter\BikePartFilterContainer $bikePartFilterContainer
	 * @return \BikeStore\Model\Filter\BikePartFilterContainer
	 */
	public function hydrate(array $data, $bikePartFilterContainer)
	{
		/** @var BikePartFilterContainer $bikePartFilterContainer */
		$bikePartFilterContainer = parent::hydrate($data, $bikePartFilterContainer);
		isset($data["equipmentTypes"]) && $bikePartFilterContainer->setEquipmentTypes($data["equipmentTypes"]);
		return $bikePartFilterContainer;
	}
}