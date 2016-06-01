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
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class ShoppingCartController extends AbstractActionController
{
	public function showShoppingCartAction(){

		$testDaten = array( //Todo löschen nach dem Testen
			array( //artikel 1
				'id' => 1,
				'count' => 1,
			),
			array( //artikel 2
				'id' => 4,
				'count' => 10,
			)
		);

		$sessionContainer = new Container("shoppingCart");
		$sessionContainer->offsetSet("articles", $testDaten); //TODO löschen nach dem testen

		$articles = array();
		if ($sessionContainer->offsetExists("articles"))
		{
			/** @var ArticleManager $articleManager */
			$articleManager = $this->getServiceLocator()->get("BikeStore.articleManager");
			$articles = $sessionContainer->offsetGet("articles");

			foreach ($articles as &$article)
			{
				$article["article"] = $articleManager->getEntityById($article["id"]);
			}
		}

		return array(
			"articles" => $articles,
		);
	}


}