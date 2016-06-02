<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 03.02.15
 * Time: 17:49
 */

namespace Portal\Controller;

use BikeStore\Model\Article;
use BikeStore\Model\Bicycle;
use BikeStore\Model\Equipment\Saddle;
use BikeStore\Model\Manager\ArticleManager;
use BikeStore\Model\Manager\Equipment\SaddleManager;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	public function indexAction()
	{
		return new ViewModel(array());
	}

	public function showImprintAction()
	{
		return new ViewModel();
	}
	
	public function showPrivacyPolicyAction()
	{
		return new ViewModel();
	}

	public function showAgbAction()
	{
		return new ViewModel();
	}
}