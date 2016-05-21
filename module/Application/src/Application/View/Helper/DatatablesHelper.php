<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 10.02.15
 * Time: 17:38
 */

namespace Application\View\Helper;

use Application\Model\Datatable\Column\Column;
use Application\Model\Datatable\Column\DialogRouteColumn;
use Application\Model\Datatable\Column\EnumColumn;
use Application\Model\Datatable\Column\JavaScriptFunctionColumn;
use Application\Model\Datatable\Column\PictureEnumColumn;
use Application\Model\Datatable\Column\RouteColumn;
use Application\Model\Datatable\Column\RouteConfirmColumn;
use Application\Model\Datatable\Datatable;
use Application\Model\Datatable\ReorderDatatable;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Renderer\PhpRenderer;

class DatatablesHelper extends AbstractHelper
{
	/** @var  PhpRenderer */
	private $phpRenderer;

	public function __construct(PhpRenderer $phpRenderer)
	{
		$this->phpRenderer = $phpRenderer;
	}

	public function __invoke(Datatable $datatable)
	{
		$this->prepareData($datatable);
		$this->appendScriptFiles();

		$datatable->prepare($this->phpRenderer);
		$script = $datatable->buildJs();
		$this->phpRenderer->inlineScript()->appendScript($script);
		
		return $datatable->build();
	}

	private function prepareData(Datatable $datatable)
	{
		$content = $datatable->getContent();
		$columns = $datatable->getColumns();
		foreach ($content as $index => &$item)
		{
			/** @var Column $column */
			foreach ($columns as $column)
			{
				if (!isset($item[$column->getName()]))
				{
					$item[$column->getName()] = "";
				}
			}
		}
		$datatable->setContent($content);

	}

	private function appendScriptFiles()
	{
		$this->phpRenderer->headScript()->appendFile($this->phpRenderer->basePath() . '/js/jquery.dataTables.js');
		$this->phpRenderer->headScript()->appendFile($this->phpRenderer->basePath() . '/js/jquery.dataTables.rowReordering.js');
		$this->phpRenderer->headScript()->appendFile($this->phpRenderer->basePath() . '/js/myDatatable.js');

		$this->phpRenderer->headLink()->appendStylesheet($this->phpRenderer->basePath() . "/css/datatable.css");
		$this->phpRenderer->headLink()->appendStylesheet($this->phpRenderer->basePath() . '/css/jquery.dataTables.css');
		$this->phpRenderer->headLink()->appendStylesheet($this->phpRenderer->basePath() . '/css/jquery.dataTables_themeroller.css');
	}
}