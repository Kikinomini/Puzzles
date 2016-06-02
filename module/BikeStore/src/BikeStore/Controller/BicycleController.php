<?php
/**
 * Created by PhpStorm.
 * User: Kinomi
 * Date: 28.05.2016
 * Time: 22:04
 */

namespace BikeStore\Controller;


use Application\Model\User;
use BikeStore\Model\Article;
use BikeStore\Model\Bicycle;
use BikeStore\Model\Manager\BicycleManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BicycleController extends AbstractActionController
{
	public function showBicycleListAction()
	{
		/** @var BicycleManager $bicycleManager */
		$bicycleManager = $this->serviceLocator->get("BikeStore.BicycleManager");
		$bicycles = $bicycleManager->findBy(array('listed'=> true));
		
		
		
		
		return array(
			'myvar' => '12',
			'bicycles'=>$bicycles,
		);
	}

	public function showBicycleDetailsAction()
	{
		
		$article = new Bicycle();
		$viewModel = new ViewModel();
		$detailList = new ViewModel();
		$detailList->setTemplate($article->getDetailViewPath());
		$viewModel->addChild($detailList, "ProductInfo");
		$viewModel->setTemplate("/bike-store/bicycle/show-bicycle-details");
		
		return $viewModel;
	}
}