<?php

namespace BikeStore\Model\Repository;

use BikeStore\Model\Filter\ArticleFilterContainer;
use BikeStore\Model\Filter\BikePartFilterContainer;
use Doctrine\ORM\QueryBuilder;

class EquipmentRepository extends ArticleRepository
{
	protected function addSelectFromCount(QueryBuilder $queryBuilder)
	{
		$queryBuilder->select($queryBuilder->expr()->count('a'))
			->addSelect($queryBuilder->expr()->max("a.price"))
			->addSelect($queryBuilder->expr()->min("a.price"))
			->from('BikeStore\Model\Equipment', 'a');
		return $this;
	}

	protected function addSelectFrom(QueryBuilder $queryBuilder)
	{
		$queryBuilder->select('a')->from('BikeStore\Model\Equipment', 'a');
		return $this;
	}

	/**
	 * @param BikePartFilterContainer $bikePartFilterContainer
	 * @param QueryBuilder $queryBuilder
	 * @return $this|void
	 */
	protected function addWhereStatement(ArticleFilterContainer $bikePartFilterContainer, QueryBuilder $queryBuilder)
	{
		parent::addWhereStatement($bikePartFilterContainer, $queryBuilder);
		$orExpr = $queryBuilder->expr()->orX();
		$equipmentTypes = $bikePartFilterContainer->getEquipmentTypes();
		foreach($equipmentTypes as $value)
		{
			$orExpr->add($queryBuilder->expr()->isInstanceOf('a', 'BikeStore\Model\Equipment\\'.$value));
		}
		$queryBuilder->andWhere($orExpr);
	}
}