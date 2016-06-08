<?php

namespace BikeStore\Model\Repository;

use Application\Model\Repository\StandardRepository;

class ArticleRepository extends StandardRepository
{
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