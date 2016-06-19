<?php
/**
 * Created by PhpStorm.
 * User: Marten
 * Date: 19.06.2016
 * Time: 20:44
 */

namespace BikeStore\Form\Hydrator;


class AddressFormHydrator implements HydratorInterface
{

	/**
	 * @param object $object
	 * @return array
	 */
	public function extract($object)
	{
		return array();
	}

	/**
	 * @param array $data
	 * @param ArticleFilterContainer $articleFilterContainer
	 * @return ArticleFilterContainer
	 */
	public function hydrate(array $data, $articleFilterContainer)
	{
		
	}

}