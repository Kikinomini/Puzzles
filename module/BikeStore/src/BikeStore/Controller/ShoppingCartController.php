<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 31.05.2016
 * Time: 17:14
 */

namespace BikeStore\Controller;


use Application\Model\User;
use BikeStore\Model\Manager\ArticleManager;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class ShoppingCartController extends AbstractActionController
{
	public function showShoppingCartAction(){
		$sessionContainer = new Container("shoppingCart");
		/*
		$testDaten = array(
			1 => array(
				'count' => 1,
			),
			4 => array(
				'count' => 10,
			),
			7 => array(
				'count' => 3,
			),
			5 => array(
				'count' => 2,
			),
		);

		$sessionContainer->offsetSet("articles", $testDaten); //TODO löschen nach dem testen
		*/

		$articles = array();
		if ($sessionContainer->offsetExists("articles"))
		{
			/** @var ArticleManager $articleManager */
			$articleManager = $this->getServiceLocator()->get("BikeStore.articleManager");
			$articles = $sessionContainer->offsetGet("articles");

			foreach ($articles as $id => &$article)
			{
				$article["article"] = $articleManager->getEntityById($id);
			}
		}

		return array(
			"articles" => $articles,
		);
	}

	public function addArticleToShoppingCartAction(){
		$sessionContainer = new Container("shoppingCart");
		/** @var Request $request */
		$request = $this->getRequest();

		$id = (int) $request->getPost('id', -1);
		$count = (int) $request->getPost('count', -1);

		$articleManager = $this->getServiceLocator()->get("BikeStore.articleManager");
		if($article = $articleManager->getEntityById($id) == null)
		{
			$this->getResponse()->setStatusCode(400);
			$this->getEventManager()->trigger('dispatchError', 'Module', $this->getEvent());
			return;
		}

		$articles = array();

		if ($sessionContainer->offsetExists("articles"))
		{
			$articles = $sessionContainer->offsetGet("articles");
		}

		if(isset($articles[$id]))
		{
			$articles[$id]["count"] += $count;
		}
		else
		{
			$articles[$id] = array(
				'count' => $count
			);
		}

		$sessionContainer->offsetSet("articles", $articles);

		$this->layout("layout/ajaxData");
		$viewModel = new ViewModel(
			array(
				"json" => array(
					"success" => true
				)
			)
		);
		$viewModel->setTemplate("ajax/json");
		return $viewModel;
	}
}