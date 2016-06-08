<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 08.06.16
 * Time: 13:30
 */

namespace BikeStore\Model\Filter;

class BikePartFilterContainer extends ArticleFilterContainer
{
	
	private $equipmentTypes = array();

	/**
	 * @return array
	 */
	public function getEquipmentTypes()
	{
		return $this->equipmentTypes;
	}

	/**
	 * @param array $equipmentTypes
	 */
	public function setEquipmentTypes($equipmentTypes)
	{
		$this->equipmentTypes = $equipmentTypes;
	}

	public function addEquipmentType($equipmentType)
	{
		if (!in_array($equipmentType, $this->equipmentTypes))
		{
			$this->equipmentTypes[] = $equipmentType;
		}
	}
}