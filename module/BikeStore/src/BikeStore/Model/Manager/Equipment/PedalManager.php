<?php

namespace BikeStore\Model\Manager\Equipment;

use Application\Model\Manager\StandardManager;
use BikeStore\Model\Equipment\Pedal;

class PedalManager extends StandardManager
{
    public static function resolvePedalType($pedalType)
    {
        switch($pedalType)
        {
            case Pedal::PEDAL_TYPE_FLAT:
            {
                return "Blockpedal";
            }
            case Pedal::PEDAL_TYPE_CLICK:
            {
                return "Klickpedal";
            }
            case Pedal::PEDAL_TYPE_SPIKED:
            {
                return "Bärentatze-Pedal";
            }
            case Pedal::PEDAL_TYPE_SPIKED_CLICK:
            {
                return "Block/Bärentatze-Pedal";
            }
            default:
            {
                return "undefined";
            }
        }
    }

    public function __construct($repository, $entity = null)
    {
        parent::__construct($repository, $entity);
    }
    
    /**
   * @return Pedal
   */
  public function getEntity()
  {
    return $this->entity;
  }

  /**
   * @param object $entity
   * @return Pedal
   */
  protected function selectCorrectEntity($entity)
  {
    return parent::selectCorrectEntity($entity);
  }

    /**
     * @param integer $id
     * @return Pedal
     */
  public function getEntityById($id)
  {
    return parent::getEntityById($id);
  }
}