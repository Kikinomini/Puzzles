<?php
/**
 * Created by PhpStorm.
 * User: Kinomi
 * Date: 28.05.2016
 * Time: 22:04
 */

namespace BikeStore\Controller;


use BikeStore\Model\Article;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BicycleController extends AbstractActionController
{
	public function showBicycleListAction()
	{
		return array(
			'myvar' => '12',
		);
	}

	public function showBicycleDetailsAction()
	{
		
		$article = new Article();
		$viewModel = new ViewModel();
		$detailList = new ViewModel();
		$detailList->setTemplate($article->getDetailViewPath());
		$viewModel->addChild($detailList, "DetailList");
		
		return $viewModel;
	}
}