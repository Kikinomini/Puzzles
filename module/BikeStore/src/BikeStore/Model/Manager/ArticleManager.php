<?php

namespace BikeStore\Model\Manager;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\Article;
use BikeStore\Model\Repository\ArticleRepository;

class ArticleManager extends StandardManager
{

	/**
	 * @param Article $article
	 * @return array
	 */
	public static function getAsArray($article)
	{
		return array(
			'pictureName' => $article->getImageName(),
			'name' => $article->getName(),
			'quickDescription' => $article->getQuickDescription(),
			'description' => $article->getDescription(),
			'price' => $article->getPrice(),
			'id' => $article->getId(),
			'listed' => $article->getListed(),
		);
	}
	
	public function searchByString($string)
	{
		/** @var ArticleRepository am*/
		$am = $this->repository;
		$am->search($string);
	}

    public function __construct($repository, $entity = null)
    {
        parent::__construct($repository, $entity);
    }
    
    /**
	 * @return Article
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param object $entity
	 * @return Article
	 */
	protected function selectCorrectEntity($entity)
	{
		return parent::selectCorrectEntity($entity);
	}

    /**
     * @param integer $id
     * @return Article
     */
	public function getEntityById($id)
	{
		return parent::getEntityById($id);
	}
}