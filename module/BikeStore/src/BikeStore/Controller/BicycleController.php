<?php
/**
 * Created by PhpStorm.
 * User: Kinomi
 * Date: 28.05.2016
 * Time: 22:04
 */

namespace BikeStore\Controller;


use Application\Model\User;
use BikeStore\Form\BicycleFilterForm;
use BikeStore\Model\Article;
use BikeStore\Model\Bicycle;
use BikeStore\Model\Filter\ArticleFilterContainer;
use BikeStore\Model\Manager\ArticleManager;
use BikeStore\Model\Manager\BicycleManager;
use BikeStore\Model\Manager\Equipment\BrakeManager;
use BikeStore\Model\Manager\Equipment\SaddleManager;
use Zend\Http\Request;
use BikeStore\Model\Repository\ArticleRepository;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class BicycleController extends AbstractActionController
{
	public function searchAction()
	{
		/** @var Request $request */
		$request = $this->getRequest();
		$searchString = $request->getQuery("search");
		/** @var ArticleManager $articleManager */
		$articleManager = $this->serviceLocator->get("BikeStore.ArticleManager");

		$articleFilter = new ArticleFilterContainer();
		$articleFilter->setSearchWords($searchString);

		$articleArray = $articleManager->findByArticleFilterContainer($articleFilter);
		var_dump($articleArray);
		
//		$foundArticles = $articleManager->findBy(array('name'=>$searchString,'quickDescription'=>$searchString));

	}
	public function showBicycleListAction()
	{
		/** @var BicycleManager $bicycleManager */
		$bicycleManager = $this->serviceLocator->get("BikeStore.BicycleManager");
		$bicycles = null;
		$filterForm = new BicycleFilterForm();

		/** @var Request $request */
		$request = $this->getRequest();
		if ($request->isGet())
		{
			$filterForm->setData($request->getQuery());
		}
		if ($bicycles == null)
		{
			$bicycles = $bicycleManager->findBy(array('listed' => true));
		}


		$page = 1;
		//$page = ceil($articleFilterContainer->getOffset()/ self::ARTICLES_PER_SIDE); //ToDo auskommentieren
		$maxPage = 10; //ToDo ändern

		return array(
			'filterForm' => $filterForm,
			'bicycles'=>$bicycles,
			'page' => $page,
			'maxPage' => $maxPage,
		);
	}

	public function showArticleDetailsAction()
	{
		$id = $this->params("id", -1);

		/** @var ArticleManager $articleManager */
		$articleManager = $this->getServiceLocator()->get("BikeStore.articleManager");
		$article = $articleManager->getEntityById($id);

		if ($article == null)
		{
			$this->getResponse()->setStatusCode(404);
			$this->getEventManager()->trigger('dispatchError', 'Module', $this->getEvent());
			return;
		}

		$possibleBrakes = array();
		$possibleSaddles = array();
		if ($article instanceof Bicycle)
		{
			/** @var BrakeManager $brakeManager */
			$brakeManager = $this->getServiceLocator()->get("BikeStore.equipment.brakeManager");
			$possibleBrakes = $brakeManager->findPossibleBrakesForBicycle($article);

			/** @var SaddleManager $saddleManager */
			$saddleManager = $this->getServiceLocator()->get("BikeStore.equipment.saddleManager");
			$possibleSaddles = $saddleManager->findPossibleSaddlesForBicycle($article);
		}

		$viewModel = new ViewModel(array(
			"article" => $article,
			"possibleBrakesFront" => $possibleBrakes,
			"possibleBrakesRear" => $possibleBrakes,
			"possibleSaddles" => $possibleSaddles,
		));
		$detailList = new ViewModel(array(
			"article" => $article
		));
		$detailList->setTemplate($article->getDetailViewPath());
		$viewModel->addChild($detailList, "ProductInfo");
		$viewModel->setTemplate("/bike-store/bicycle/show-bicycle-details");

		return $viewModel;
	}
}