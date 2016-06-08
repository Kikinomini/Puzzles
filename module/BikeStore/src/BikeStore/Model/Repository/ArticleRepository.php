<?php

namespace BikeStore\Model\Repository;

use Application\Model\Repository\StandardRepository;
use BikeStore\Model\Filter\ArticleFilterContainer;
use Doctrine\ORM\QueryBuilder;

class ArticleRepository extends StandardRepository
{
	public function findByArticleFilterContainer(ArticleFilterContainer $articleFilterContainer)
	{
		$queryManager = $this->_em->createQueryBuilder();
		$this->addSelectFrom($queryManager);
		$queryManager->where("a.listed = :listedVal");
		$queryManager->setParameter("listedVal", true);
		$this->addWhereStatement($articleFilterContainer, $queryManager);
		$this->addOffsetLimit($articleFilterContainer, $queryManager);
		
		return $queryManager->getQuery()->getResult();
	}
	protected function addSelectFrom(QueryBuilder $queryBuilder)
	{
		$queryBuilder->select('a')->from('BikeStore\Model\Article', 'a');
		return $this;
	}
	protected function addWhereStatement(ArticleFilterContainer $articleFilterContainer, QueryBuilder $queryBuilder)
	{
		$this->addSearchExpressions($articleFilterContainer, $queryBuilder);

		if ($articleFilterContainer->isPriceMinSet())
		{
			$queryBuilder->andWhere("a.price >= :priceMin");
			$queryBuilder->setParameter("priceMin", $articleFilterContainer->getPriceMin());
		}
		if ($articleFilterContainer->isPriceMaxSet())
		{
			$queryBuilder->andWhere("a.price <= :priceMax");
			$queryBuilder->setParameter("priceMax", $articleFilterContainer->getPriceMax());
		}

		return $this;
	}
	protected function addOffsetLimit(ArticleFilterContainer $articleFilterContainer, QueryBuilder $queryBuilder)
	{
		if ($articleFilterContainer->getLimit() > 0)
		{
			$queryBuilder->setMaxResults($articleFilterContainer->getLimit());
		}
		if ($articleFilterContainer->getOffset() > 0)
		{
			$queryBuilder->setFirstResult($articleFilterContainer->getOffset());
		}
	}
	private function addSearchExpressions(ArticleFilterContainer $articleFilterContainer, QueryBuilder $queryBuilder)
	{
		$orExpr = $queryBuilder->expr()->orX();
		$searchWords = $articleFilterContainer->getSearchWords();
		foreach($searchWords as $index => $word)
		{
			if (!$articleFilterContainer->isCaseSensitive())
			{
				$orExpr->add($queryBuilder->expr()->like("LOWER(a.name)", ":word".$index));
				$orExpr->add($queryBuilder->expr()->like("LOWER(a.quickDescription)", "%".$word."%"));
				$orExpr->add($queryBuilder->expr()->like("LOWER(a.colour)", "%".$word."%"));
			}
			else
			{
				$orExpr->add($queryBuilder->expr()->like("a.name", "%".$word."%"));
				$orExpr->add($queryBuilder->expr()->like("a.quickDescription", "%".$word."%"));
				$orExpr->add($queryBuilder->expr()->like("a.colour", "%".$word."%"));
			}
		}
		$queryBuilder->andWhere($orExpr);
	}
	public function search($string)
	{
		$words = mb_split(" ", $string);
		$queryBuilder = $this->_em->createQueryBuilder();
		$wordCount = count($words);
		$queryBuilder->select('a')
			->from('BikeStore\Model\Article','a')
			->where('a.name LIKE :name')
			->setParameter("name","%".$words[0]."%")
			->orWhere('a.quickDescription LIKE :qickDes')
			->setParameter('qickDes',"%".$words[0]."%");
		foreach ($words as $key => $value)
		{
			$queryBuilder->orWhere('a.name LIKE :name')
				->setParameter("name","%".$value."%")
				->orWhere('a.quickDescription LIKE :quickDes')
				->setParameter('quickDes',"%".$value."%");
		}
		$query = $queryBuilder->getQuery();
		$array = $query->getArrayResult();


//		for($i = 0;$i<$wordCount;$i++)
//		{
//			$queryBuilder->addCriteria();
//		}
//		$queryBuilder->where('name = ?');

		return $array;

	}
}