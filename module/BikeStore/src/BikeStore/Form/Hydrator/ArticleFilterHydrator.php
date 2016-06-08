<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 08.06.16
 * Time: 08:50
 */

namespace BikeStore\Form\Hydrator;


use BikeStore\Model\Filter\ArticleFilterContainer;
use Zend\Stdlib\Hydrator\HydratorInterface;

class ArticleFilterHydrator implements HydratorInterface
{
	public function extract($object)
	{
		return array();
	}

	/**
	 * @param array $data
	 * @param ArticleFilterContainer $bikePartFilterContainer
	 * @return ArticleFilterContainer
	 */
	public function hydrate(array $data, $bikePartFilterContainer)
	{
		isset($data["search"]) && $bikePartFilterContainer->setSearchWords($data["search"]);
		isset($data["priceMin"]) && $bikePartFilterContainer->setPriceMin(floatval($data["priceMin"]));
		isset($data["priceMax"]) && $bikePartFilterContainer->setPriceMax(floatval($data["priceMax"]));

		return $bikePartFilterContainer;
	}
}