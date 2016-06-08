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
use BikeStore\Model\Manager\ArticleManager;
use BikeStore\Model\Manager\BicycleManager;
use Zend\Http\Request;
use BikeStore\Model\Repository\ArticleRepository;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class BicycleController extends AbstractActionController
{
	public function searchAction()
	{
		/** @var Request $request */
		$request = $this->getRequest();
		$searchString = $request->getQuery("s");
		/** @var ArticleManager $articleManager */
		$articleManager = $this->serviceLocator->get("BikeStore.ArticleManager");

		$article = $articleManager->searchByString($searchString);
		var_dump($article);



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

		return array(
			'filterForm' => $filterForm,
			'bicycles'=>$bicycles,
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

		$viewModel = new ViewModel(array(
			"article" => $article
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