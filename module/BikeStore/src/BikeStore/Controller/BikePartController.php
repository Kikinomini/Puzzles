<?php
/**
 * Created by PhpStorm.
 * User: Marten
 * Date: 01.06.2016
 * Time: 10:55
 */

namespace BikeStore\Controller;


use BikeStore\Form\ArticleFilterForm;
use BikeStore\Form\BikePartFilterForm;
use BikeStore\Form\Hydrator\ArticleFilterHydrator;
use BikeStore\Form\Hydrator\BikePartFilterHydrator;
use BikeStore\Model\Filter\ArticleFilterContainer;
use BikeStore\Model\Filter\BikePartFilterContainer;
use BikeStore\Model\Manager\EquipmentManager;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;

class BikePartController extends AbstractActionController
{
	const ARTICLES_PER_SIDE = 15;

	public function showBikePartListAction()
	{
		/** @var EquipmentManager $equipmentManager */
		$equipmentManager = $this->serviceLocator->get('BikeStore.equipmentManager');

		$filterForm = new BikePartFilterForm();

		/** @var Request $request */
		$request = $this->getRequest();
		$articleFilterContainer = new BikePartFilterContainer();
		$articleFilterContainer->setLimit(self::ARTICLES_PER_SIDE);

		if($request->isGet())
		{
			$data = $request->getQuery()->toArray();
//			$articleFilterContainer->setSearchWords("Licht Bremse");
			$hydrator = new BikePartFilterHydrator();
			$hydrator->hydrate($data, $articleFilterContainer);
			$filterForm->setData($data);
		}

		$articles = $equipmentManager->findByArticleFilterContainer($articleFilterContainer);
		return array(
			"equipments" => $articles,
			"filterForm" => $filterForm,
		);
	}

	public function showBikepartDetailsAction()
	{
		return array(
			'myvar' => '12',
		);

	}
}