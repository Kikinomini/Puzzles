<?php
/**
 * Created by PhpStorm.
 * User: Kinomi
 * Date: 28.05.2016
 * Time: 22:04
 */

namespace BikeStore\Controller;


use Zend\Mvc\Controller\AbstractActionController;

class BicycleController extends AbstractActionController
{
	public function showBicycleListAction(){
		return array(
			'myvar' => '12',
		);
	}

	public function showBicycleDetailsAction(){
		return array();
	}
}