<?php

namespace BikeStore\Model\Manager;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\Article;
use BikeStore\Model\Equipment;

class EquipmentManager extends StandardManager
{
	/**
	 * @param Article $article
	 * @return array
	 */
	public static function getAsArray($article)
	{
		return ArticleManager::getAsArray($article);
	}
	
    public function __construct($repository, $entity = null)
    {
        parent::__construct($repository, $entity);
    }
    
    /**
	 * @return Equipment
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param object $entity
	 * @return Equipment
	 */
	protected function selectCorrectEntity($entity)
	{
		return parent::selectCorrectEntity($entity);
	}

    /**
     * @param integer $id
     * @return Equipment
     */
	public function getEntityById($id)
	{
		return parent::getEntityById($id);
	}
}