<?php

namespace BikeStore\Model\Repository;

use BikeStore\Model\Filter\ArticleFilterContainer;
use BikeStore\Model\Filter\BicycleFilterContainer;
use Doctrine\ORM\QueryBuilder;

class BicycleRepository extends ArticleRepository
{
	protected function addSelectFrom(QueryBuilder $queryBuilder)
	{
		$queryBuilder->select('a')->from('BikeStore\Model\Bicycle', 'a');
		$queryBuilder->innerJoin('a.frame', 'f');
		return $this;
	}

	/**
	 * @param BicycleFilterContainer $bicycleFilterContainer
	 * @param QueryBuilder $queryBuilder
	 * @return $this|void
	 */
	protected function addWhereStatement(ArticleFilterContainer $bicycleFilterContainer, QueryBuilder $queryBuilder)
	{
		parent::addWhereStatement($bicycleFilterContainer, $queryBuilder);

		$this->addRiderTypeWhereStatement($bicycleFilterContainer, $queryBuilder);
		$this->addFrameTypeWhereStatement($bicycleFilterContainer, $queryBuilder);

		if ($bicycleFilterContainer->isFrameHeightMinSet())
		{
			$queryBuilder->andWhere("f.frameSize >= :frameHeightMin" );
			$queryBuilder->setParameter("frameHeightMin", $bicycleFilterContainer->getFrameHeightMin());
		}

		if ($bicycleFilterContainer->isFrameHeightMaxSet())
		{
			$queryBuilder->andWhere("f.frameSize <= :frameHeightMax" );
			$queryBuilder->setParameter("frameHeightMax", $bicycleFilterContainer->getFrameHeightMax());
		}
	}

	private function addRiderTypeWhereStatement(BicycleFilterContainer $bicycleFilterContainer, QueryBuilder $queryBuilder)
	{
		$orExpr = $queryBuilder->expr()->orX();
		$riderTypes = $bicycleFilterContainer->getRiderTypes();
		foreach($riderTypes as $value)
		{
			$orExpr->add($queryBuilder->expr()->eq("f.riderType", $value));
		}
		$queryBuilder->andWhere($orExpr);
	}

	private function addFrameTypeWhereStatement(BicycleFilterContainer $bicycleFilterContainer, QueryBuilder $queryBuilder)
	{
		$orExpr = $queryBuilder->expr()->orX();
		$frameTypes = $bicycleFilterContainer->getFrameTypes();
		foreach($frameTypes as $value)
		{
			$orExpr->add($queryBuilder->expr()->eq("f.bikeType", $value));
		}
		$queryBuilder->andWhere($orExpr);
	}
}