<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 08.06.16
 * Time: 10:58
 */

namespace BikeStore\Form;


use Application\Model\Form\Element\MyMultiCheckbox;
use BikeStore\Model\Manager\EquipmentManager;
use Zend\Form\Element\MultiCheckbox;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class BikePartFilterForm extends ArticleFilterForm
{
	public function __construct(FlashMessenger $flashMessenger = null, $name = null, array $options = array())
	{
		parent::__construct($flashMessenger, $name, $options);
		$this->setAttribute("id", "bikePartFilterForm");
	}

	public function addElements()
	{
		parent::addElements();

		$equipmentTypes = new MultiCheckbox("equipmentTypes");
		$equipmentTypes->setAttribute("class", "");
		$equipmentTypes->setValueOptions(array(
			EquipmentManager::BATTERY => "Batterie",
			EquipmentManager::BRAKE => "Bremse",
			EquipmentManager::DYNAMO => "Dynamo",
			EquipmentManager::GEAR_SHIFT => "Gangschaltung",
			EquipmentManager::PANNIER_RACK => "Gepäckträger",
			EquipmentManager::REAR_WHEEL => "Hinterrad",
			EquipmentManager::BELL => "Klingel",
			EquipmentManager::HANDLEBARS => "Lenker",
			EquipmentManager::LIGHT => "Licht",
			EquipmentManager::COAT => "Mantel",
			EquipmentManager::PEDAL => "Pedal",
			EquipmentManager::FRAME => "Rahmen",
			EquipmentManager::SADDLE => "Sattel",
			EquipmentManager::SADDLE_BAR => "Sattelstange",
			EquipmentManager::TUBE => "Schlauch",
			EquipmentManager::MUD_GUARD => "Schutzblech",
			EquipmentManager::FRONT_WHEEL => "Vorderrad",
		));
		$this->setSendFormOnClickClasses($equipmentTypes);
		$this->add($equipmentTypes);
	}
}