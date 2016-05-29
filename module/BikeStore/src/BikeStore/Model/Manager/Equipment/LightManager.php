<?php

namespace BikeStore\Model\Manager\Equipment;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\Equipment\Light;

class LightManager extends StandardManager
{
    public function __construct($repository, $entity = null)
    {
        parent::__construct($repository, $entity);
    }
    
    /**
   * @return Light
   */
  public function getEntity()
  {
    return $this->entity;
  }

  /**
   * @param object $entity
   * @return Light
   */
  protected function selectCorrectEntity($entity)
  {
    return parent::selectCorrectEntity($entity);
  }

    /**
     * @param integer $id
     * @return Light
     */
  public function getEntityById($id)
  {
    return parent::getEntityById($id);
  }
}