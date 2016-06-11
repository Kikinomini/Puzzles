<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 31.05.2016
 * Time: 17:14
 */

namespace BikeStore\Controller;


use Application\Model\User;
use BikeStore\Model\Bicycle;
use BikeStore\Model\Equipment\Brake;
use BikeStore\Model\Manager\ArticleManager;
use BikeStore\Model\Manager\BicycleManager;
use BikeStore\Model\Manager\Equipment\BrakeManager;
use BikeStore\Model\Manager\Equipment\SaddleManager;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class ShoppingCartController extends AbstractActionController
{
	public function showShoppingCartAction()
	{
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
		if($sessionContainer->offsetExists("articles"))
		{
			/** @var ArticleManager $articleManager */
			$articleManager = $this->getServiceLocator()->get("BikeStore.articleManager");
			$articles = $sessionContainer->offsetGet("articles");

			foreach($articles as $id => &$article)
			{
				$article["article"] = $articleManager->getEntityById($id);
			}
		}

		return array(
			"articles" => $articles,
		);
	}

	private function updateFrontBrake(Bicycle $bicycle)
	{
		/** @var Request $request */
		$request = $this->getRequest();
		$frontBrakeId = (int)$request->getPost('selectBrakeFront', -1);
		/** @var BrakeManager $brakeManager */
		$brakeManager = $this->getServiceLocator()->get("BikeStore.equipment.brakeManager");

		if($frontBrakeId != $bicycle->getFrontBrake()->getId() && $frontBrakeId > 0)
		{
			$frontBrake = $brakeManager->getEntityById($frontBrakeId);
			if($frontBrake == null)
			{
				return null;
			}
			$bicycle = clone $bicycle;
			$bicycle->setId(null);
			$bicycle->setListed(false);
			$bicycle->setPrice($bicycle->getPrice() + $frontBrake->getPrice() - $bicycle->getFrontBrake()->getPrice());
			$bicycle->setFrontBrake($frontBrake);
			return $bicycle;
		}
		return $bicycle;
	}

	private function updateRearBrake(Bicycle $bicycle)
	{
		/** @var Request $request */
		$request = $this->getRequest();
		$rearBrakeId = (int)$request->getPost('selectBrakeRear', -1);
		/** @var BrakeManager $brakeManager */
		$brakeManager = $this->getServiceLocator()->get("BikeStore.equipment.brakeManager");

		if($rearBrakeId != $bicycle->getRearBrake()->getId() && $rearBrakeId > 0)
		{
			$rearBrake = $brakeManager->getEntityById($rearBrakeId);
			if($rearBrake == null)
			{
				return null;
			}
			$bicycle = clone $bicycle;
			$bicycle->setId(null);
			$bicycle->setListed(false);
			$bicycle->setPrice($bicycle->getPrice() + $rearBrake->getPrice() - $bicycle->getRearBrake()->getPrice());
			$bicycle->setRearBrake($rearBrake);
			return $bicycle;
		}
		return $bicycle;
	}

	private function updateSaddle(Bicycle $bicycle)
	{
		/** @var Request $request */
		$request = $this->getRequest();
		$saddleId = (int)$request->getPost('selectSaddle', -1);
		/** @var SaddleManager $brakeManager */
		$brakeManager = $this->getServiceLocator()->get("BikeStore.equipment.saddleManager");

		if($saddleId != $bicycle->getSaddle()->getId() && $saddleId > 0)
		{
			$saddle = $brakeManager->getEntityById($saddleId);
			if($saddle == null)
			{
				return null;
			}
			$bicycle = clone $bicycle;
			$bicycle->setId(null);
			$bicycle->setListed(false);
			$bicycle->setPrice($bicycle->getPrice() + $saddle->getPrice() - $bicycle->getSaddle()->getPrice());
			$bicycle->setSaddle($saddle);
			return $bicycle;
		}
		return $bicycle;
	}

	public function addArticleToShoppingCartAction()
	{
		$sessionContainer = new Container("shoppingCart");
		/** @var Request $request */
		$request = $this->getRequest();

		$id = (int)$request->getPost('id', -1);
		$count = (int)$request->getPost('count', -1);

		/** @var ArticleManager $articleManager */
		$articleManager = $this->getServiceLocator()->get("BikeStore.articleManager");
		if(($article = $articleManager->getEntityById($id)) == null || $count <= 0)
		{
			$this->getResponse()->setStatusCode(400);
			$this->getEventManager()->trigger('dispatchError', 'Module', $this->getEvent());
			return;
		}

		if($article instanceof Bicycle)
		{
			$oldArticle = $article;
			if(($article = $this->updateFrontBrake($article)) == null ||
			   ($article = $this->updateRearBrake($article)) == null ||
			   ($article = $this->updateSaddle($article)) == null
			)
			{
				$this->getResponse()->setStatusCode(400);
				$this->getEventManager()->trigger('dispatchError', 'Module', $this->getEvent());
				return;
			}
//
			if($oldArticle != $article)
			{
				/** @var BicycleManager $bicycleManager */
				$bicycleManager = $this->getServiceLocator()->get("BikeStore.bicycleManager");
				$databaseArticle = $bicycleManager->findOneByBicycle($article);
				if($databaseArticle == null)
				{
					$bicycleManager->save($article);
				}
				else
				{
					$article = $databaseArticle;
				}
			}
		}
		$articles = array();
		if($sessionContainer->offsetExists("articles"))
		{
			$articles = $sessionContainer->offsetGet("articles");
		}

		$id = $article->getId();
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

	public function deleteArticleFromShoppingCartAction()
	{
		$sessionContainer = new Container("shoppingCart");
		/** @var Request $request */
		$request = $this->getRequest();

		$id = (int)$request->getPost('id', -1);

		if($id == -1)
		{
			$this->getResponse()->setStatusCode(400);
			$this->getEventManager()->trigger('dispatchError', 'Module', $this->getEvent());
			return;
		}

		if(!$sessionContainer->offsetExists("articles"))
		{
			$this->getResponse()->setStatusCode(404);
			$this->getEventManager()->trigger('dispatchError', 'Module', $this->getEvent());
			return;
		}
		$articles = $sessionContainer->offsetGet("articles");

		if(isset($articles[$id]))
		{
			unset($articles[$id]);
			$sessionContainer->offsetSet("articles", $articles);
		}
		else
		{
			$this->getResponse()->setStatusCode(404);
			$this->getEventManager()->trigger('dispatchError', 'Module', $this->getEvent());
			return;
		}

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


	public function changeCountOfArticleAction()
	{

	}
}