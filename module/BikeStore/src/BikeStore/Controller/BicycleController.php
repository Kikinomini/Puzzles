<?php
/**
 * Created by PhpStorm.
 * User: Kinomi
 * Date: 28.05.2016
 * Time: 22:04
 */

namespace BikeStore\Controller;


use Application\Model\User;
use BikeStore\Form\ArticleFilterForm;
use BikeStore\Form\BicycleFilterForm;
use BikeStore\Form\Hydrator\BicycleFilterHydrator;
use BikeStore\Model\Article;
use BikeStore\Model\Bicycle;
use BikeStore\Model\Filter\ArticleFilterContainer;
use BikeStore\Model\Filter\BicycleFilterContainer;
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
	const ARTICLES_PER_SIDE = 15;

	public function searchAction()
	{
		/** @var Request $request */
		$request = $this->getRequest();
		/** @var ArticleManager $articleManager */
		$articleManager = $this->serviceLocator->get("BikeStore.ArticleManager");

		$articleFilterContainer = new ArticleFilterContainer();
		$filterForm = new ArticleFilterForm();

		$filterForm->bind($articleFilterContainer);
		if ($request->isGet())
		{
			$data = $request->getQuery()->toArray();
			$filterForm->setData($data);
			$filterForm->isValid();
		}
		
		$articleFilterContainer->setLimit(self::ARTICLES_PER_SIDE);

		$articleArray = $articleManager->findByArticleFilterContainer($articleFilterContainer);

		$page = ceil($articleFilterContainer->getOffset() / self::ARTICLES_PER_SIDE) + 1;
		$maxPage = ceil($articleFilterContainer->getNumberResultsWithoutLimitOffset() / self::ARTICLES_PER_SIDE);

		$page = ($page > $maxPage)? 1:$page;
		$page = ($page <= 0)? 1:$page;
		
		return array(
			'filterForm' => $filterForm,
			"result" => $articleArray,
			'page' => $page,
			'maxPage' => $maxPage,
		);
	}
	public function showBicycleListAction()
	{
		/** @var BicycleManager $bicycleManager */
		$bicycleManager = $this->serviceLocator->get("BikeStore.BicycleManager");
		$bicycles = null;
		$filterForm = new BicycleFilterForm();


		/** @var Request $request */
		$request = $this->getRequest();
		$articleFilterContainer = new BicycleFilterContainer();
		$articleFilterContainer->setLimit(self::ARTICLES_PER_SIDE);

		$filterForm->bind($articleFilterContainer);
		if ($request->isGet())
		{
			$data = $request->getQuery()->toArray();
			$filterForm->setData($data);
			$filterForm->isValid();
		}

		$bicycles = $bicycleManager->findByArticleFilterContainer($articleFilterContainer);

		$page = ceil($articleFilterContainer->getOffset()/ self::ARTICLES_PER_SIDE)+1;
		$maxPage = ceil($articleFilterContainer->getNumberResultsWithoutLimitOffset()/ self::ARTICLES_PER_SIDE);

		$page = ($page > $maxPage)? 1:$page;
		$page = ($page <= 0)? 1:$page;

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