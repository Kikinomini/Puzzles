<?php
/**
 * Created by PhpStorm.
 * User: Marten
 * Date: 01.06.2016
 * Time: 10:55
 */

namespace BikeStore\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BikePartController extends AbstractActionController
{
	public function showBikePartListAction()
	{
		var_dump($var = 5);

		return array(
			'myvar' => '12',
		);
	}

	public function showBikepartDetailsAction()
	{
		return array(
			'myvar' => '12',
		);

	}
}