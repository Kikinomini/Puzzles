<?php
/**
 * Created by PhpStorm.
 * User: Marten
 * Date: 01.06.2016
 * Time: 10:55
 */

namespace BikeStore\Controller;


use BikeStore\Model\Manager\EquipmentManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BikePartController extends AbstractActionController
{
	public function showBikePartListAction()
	{
		/** @var EquipmentManager $EquipmenManeger */
		$EquipmenManeger = $this->serviceLocator->get('BikeStore.equipmentManager');
		
		$r_value = $EquipmenManeger->findBy(array(
			"listed" => true,
		));
		return array("equipments" => $r_value);
	}

	public function showBikepartDetailsAction()
	{
		return array(
			'myvar' => '12',
		);

	}
}