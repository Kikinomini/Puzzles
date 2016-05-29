<?php

namespace BikeStore\Model\Manager\Equipment;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\Equipment\Dynamo;

class DynamoManager extends StandardManager
{
    public function __construct($repository, $entity = null)
    {
        parent::__construct($repository, $entity);
    }
    
    /**
   * @return Dynamo
   */
  public function getEntity()
  {
    return $this->entity;
  }

  /**
   * @param object $entity
   * @return Dynamo
   */
  protected function selectCorrectEntity($entity)
  {
    return parent::selectCorrectEntity($entity);
  }

    /**
     * @param integer $id
     * @return Dynamo
     */
  public function getEntityById($id)
  {
    return parent::getEntityById($id);
  }
}