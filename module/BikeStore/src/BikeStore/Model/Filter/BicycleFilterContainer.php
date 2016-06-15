<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 14.06.16
 * Time: 16:16
 */

namespace BikeStore\Model\Filter;

class BicycleFilterContainer extends ArticleFilterContainer
{
	private $frameTypes = array();
	private $riderTypes = array();
	private $frameHeightMin;
	private $frameHeightMax;

	/**
	 * @return array
	 */
	public function getFrameTypes()
	{
		return $this->frameTypes;
	}

	/**
	 * @param array $frameTypes
	 */
	public function setFrameTypes($frameTypes)
	{
		$this->frameTypes = $frameTypes;
	}


	public function addFrameType($frameType)
	{
		if (!in_array($frameType, $this->frameTypes))
		{
			$this->frameTypes[] = $frameType;
		}
	}

	/**
	 * @return array
	 */
	public function getRiderTypes()
	{
		return $this->riderTypes;
	}

	/**
	 * @param array $riderTypes
	 */
	public function setRiderTypes($riderTypes)
	{
		$this->riderTypes = $riderTypes;
	}

	public function addRiderType($riderType)
	{
		if (!in_array($riderType, $this->riderTypes))
		{
			$this->riderTypes[] = $riderType;
		}
	}

	/**
	 * @return mixed
	 */
	public function getFrameHeightMin()
	{
		return $this->frameHeightMin;
	}

	/**
	 * @param mixed $frameHeightMin
	 */
	public function setFrameHeightMin($frameHeightMin)
	{
		$this->frameHeightMin = $frameHeightMin;
	}

	/**
	 * @return mixed
	 */
	public function getFrameHeightMax()
	{
		return $this->frameHeightMax;
	}

	/**
	 * @param mixed $frameHeightMax
	 */
	public function setFrameHeightMax($frameHeightMax)
	{
		$this->frameHeightMax = $frameHeightMax;
	}

	public function isFrameHeightMinSet()
	{
		return ($this->frameHeightMin != null && $this->frameHeightMin > 0);
	}

	public function isFrameHeightMaxSet()
	{
		return ($this->frameHeightMax != null && $this->frameHeightMax > 0);
	}
}