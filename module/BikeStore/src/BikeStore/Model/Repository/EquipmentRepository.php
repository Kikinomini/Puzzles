<?php

namespace BikeStore\Model\Repository;


use BikeStore\Model\Filter\ArticleFilterContainer;
use BikeStore\Model\Filter\BikePartFilterContainer;
use Doctrine\ORM\QueryBuilder;

class EquipmentRepository extends ArticleRepository
{
	protected function addSelectFrom(QueryBuilder $queryBuilder)
	{
		$queryBuilder->select('a')->from('BikeStore\Model\Equipment', 'a');
		return $this;
	}

	protected function addWhereStatement(BikePartFilterContainer $bikePartFilterContainer, QueryBuilder $queryBuilder)
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