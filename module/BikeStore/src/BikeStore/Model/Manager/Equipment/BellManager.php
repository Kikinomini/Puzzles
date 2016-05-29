<?php

namespace BikeStore\Model\Manager\Equipment;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\Equipment\Bell;

class BellManager extends StandardManager
{
    public function __construct($repository, $entity = null)
    {
        parent::__construct($repository, $entity);
    }
    
    /**
   * @return Bell
   */
  public function getEntity()
  {
    return $this->entity;
  }

  /**
   * @param object $entity
   * @return Bell
   */
  protected function selectCorrectEntity($entity)
  {
    return parent::selectCorrectEntity($entity);
  }

    /**
     * @param integer $id
     * @return Bell
     */
  public function getEntityById($id)
  {
    return parent::getEntityById($id);
  }
}