<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 10.02.15
 * Time: 17:34
 */

namespace Application\Model\Datatable;

use Application\Model\Datatable\Column\Column;
use Application\Model\MyArrayList;
use Zend\View\Renderer\PhpRenderer;

class Datatable
{
	private $content;

	private $id;

	/** @var MyArrayList */
	private $columns;

	private $tableAttributes;

	private $hideTablehead;

	private $hideTablefoot;

	private $paginate;

	private $scrollY;

	/** @var  bool */
	private $sortable;

	/** @var  int */
	private $pageLength;

	private $lengthMenu;

	private $hasDefaultRoute;

	private $routeName;
	private $routeStaticParams;
	private $routeDynamicParams;
	private $target;

	/** @var  PhpRenderer */
	protected $phpRenderer;

	public function __construct($id, $options = array())
	{
		$this->phpRenderer = null;

		$this->routeName = "";
		$this->routeDynamicParams = array();
		$this->routeStaticParams = array();
		$this->hasDefaultRoute = false;
		$this->target = "_self";

		$this->content = array();
		$this->columns = new MyArrayList();
		$this->hideTablehead = false;
		$this->hideTablefoot = false;
		$this->paginate = true;
		$this->pageLength = 10;
		$this->scrollY = "500px";
		$this->tableAttributes = array(
			'class' => 'table table-striped datatable maxWidth',
			'width' => '100%',
		);

		$this->lengthMenu = array(
			"10" => 10,
			"25" => 25,
			"50" => 50,
			"100" => 100,
		);

		$this->setSortable(true);

		$this->setOptions($options);
		$this->setId($id);
	}

	public function prepare(PhpRenderer $phpRenderer)
	{
		$this->phpRenderer = $phpRenderer;
		/** @var Column $column */
		foreach ($this->columns as $column)
		{
			$column->prepare($phpRenderer);
			if ($this->isHasDefaultRoute() && !$column->isHasDefaultRoute())
			{
				$column->setHasDefaultRoute(true);
				$column->setRouteName($this->getRouteName());
				$column->setRouteDynamicParams($this->getRouteDynamicParams());
				$column->setRouteStaticParams($this->getRouteStaticParams());
				$column->setTarget($this->getTarget());
			}
		}
	}

	protected function buildJsAdditionalFunctions()
	{
		return "";
	}

	public function buildJs()
	{
		$id = $this->getId();
		$scriptBuidInitObject = $this->buildJsInitObject();
		$scriptAdditionalFunctions = $this->buildJsAdditionalFunctions();

		$script =
			<<<JS
					$(document).ready(function() {
					$scriptBuidInitObject
		$("#$id").dataTable(dataTableInitObject);
		$scriptAdditionalFunctions
	});
JS;

		return $script;
	}

	private function buildJsColumns()
	{
		$script = "";
		$arrayColumns = $this->buildJsColumnArray();
		foreach ($arrayColumns as $arrayColumn)
		{
			$script .= ",".PHP_EOL."{".$this->buildJsColumn($arrayColumn)."}";
		}
		return substr($script, strlen(",".PHP_EOL));
	}

	private function buildJsColumn(array $arrayColumn)
	{
		$script = "";
		foreach ($arrayColumn as $key => $value)
		{
			$script .= ",".PHP_EOL.$key.":".$value;
		}
		return substr($script, strlen(",".PHP_EOL));
	}

	private function buildJsColumnArray()
	{
		$arrayColumns = array();
		/** @var Column $column */
		foreach ($this->columns as $column)
		{
			$index = count($arrayColumns);
			$arrayColumns[$index] = $column->buildJsArray();
			$arrayColumns[$index]["aTargets"] = "[".$index."]";
			if (!$this->isSortable())
			{
				$arrayColumns[$index]["bSortable"] = "false";
			}
		}
		return $arrayColumns;
	}


	private function buildJsInitObject()
	{
		$pageLength = $this->getPageLength();
		$lengthMenu = $this->getLengthMenu();
		$lengthMenu = "[[" . implode(", ", $lengthMenu) . "], [\"" . implode("\",\"", array_keys($lengthMenu)) . "\"]]";
		$paginate = ($this->isPaginate())?"true":"false";

		$scriptColumns = $this->buildJsColumns();

		$script = <<<JS
		var dataTableInitObject = {
					oLanguage :{
				sEmptyTable: "<b>Keine Daten vorhanden.</b>",
				sInfo: "Zeige _START_ bis _END_ Einträge, von _TOTAL_ Einträgen",
				sInfoEmpty: "Keine Einträge vorhanden",
				sInfoFiltered: "(gefiltert von _MAX_ Einträgen)",
				sInfoThousands: ".",
				sLengthMenu: "Zeige _MENU_ Einträge",
				sZeroRecords: "Keine Einträge gefunden",
				sSearch: "Suche:",
				emptyTable: "Keine Daten vorhanden",
				oPaginate: {
					sNext: "Nächste Seite",
					sPrevious: "Vorherige Seite"
				}
			},
			 dom: '<"top"lpf<"clear">>rt<"bottom"ip<"clear">>'
					};
					dataTableInitObject.pageLength = $pageLength;
		dataTableInitObject.lengthMenu = $lengthMenu;
		dataTableInitObject.bPaginate = $paginate;
		dataTableInitObject.aoColumnDefs = [$scriptColumns];
JS;
		return $script;
	}

	public function build()
	{
		$tableOpenTag = "<table id = '" . $this->getId() . "' ";
		foreach ($this->getTableAttributes() as $key => $value)
		{
			$tableOpenTag .= " " . $key . " = '" . $value . "' ";
		}
		$tableOpenTag .= ">";

		$tableHead = $this->buildHead();
		$tableBody = $this->buildBody();
		$tableFood = $this->buildFoot();

		$tableCloseTag = "</table>";

		$table = $tableOpenTag
			. $tableHead
			. $tableBody
			.$tableFood
			. $tableCloseTag;

		return $table;
	}

	private function buildFoot()
	{
		if (!$this->isHideTablefoot())
		{
			$tableFood = "<tfoot><tr id = '" . $this->getId() . "_foot'>";
			/** @var Column $column */
			foreach ($this->columns as $column)
			{
				$tableFood .= $column->buildHeadCell();
			}
			$tableFood .= "</tr></tfoot>";
			return $tableFood;
		}
		return "";
	}

	private function buildHead()
	{
		if (!$this->isHideTablehead())
		{
			$tableHead = "<thead><tr id = '" . $this->getId() . "_head'>";
			/** @var Column $column */
			foreach ($this->columns as $column)
			{
				$tableHead .= $column->buildHeadCell();
			}
			$tableHead .= "</tr></thead>";
			return $tableHead;
		}
		return "";
	}

	private function buildBody()
	{
		$tableBody = "<tbody>";
		$countRows = count($this->content);
		for ($i = 0; $i < $countRows; $i++)
		{
			$tableBody .= $this->buildRow($i);
		}

		$tableBody .= "</tbody>";
		return $tableBody;
	}

	private function buildRow($index)
	{
		$row = "<tr id = '" . $this->getId() . "_" . $index . "'>";
		/** @var Column $column */
		foreach ($this->columns as $column)
		{
			$row .= $column->buildCell($this->content[$index], $index);
		}
		$row .= "</tr>";
		return $row;
	}

	/**
	 * @return mixed
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * @param mixed $content
	 */
	public function setContent(array $content)
	{
		$this->content = $content;
	}

	/**
	 * @return MyArrayList
	 */
	public function getColumns()
	{
		return $this->columns;
	}

	/**
	 * @return boolean
	 */
	public function isSortable()
	{
		return $this->sortable;
	}

	/**
	 * @param boolean $sortable
	 */
	public function setSortable($sortable)
	{
		$this->sortable = ($sortable == true);
	}

	/**
	 * @return int
	 */
	public function getPageLength()
	{
		return $this->pageLength;
	}

	/**
	 * @param int $pageLength
	 */
	public function setPageLength($pageLength)
	{
		$this->pageLength = $pageLength;
	}

	/**
	 * @return array
	 */
	public function getLengthMenu()
	{
		return $this->lengthMenu;
	}

	/**
	 * @param array $lengthMenu
	 */
	public function setLengthMenu($lengthMenu)
	{
		$this->lengthMenu = $lengthMenu;
	}

	/**
	 * @param array $columns
	 */
	public function setColumns(array $columns)
	{
		$this->columns = new MyArrayList();
		foreach ($columns as $column)
		{
			$this->addColumn($column);
		}
	}

	public function addColumn(Column $column, $position = -1)
	{
		foreach ($this->columns as $columnEntity)
		{
			if ($columnEntity->getName() == $column->getName())
			{
				throw new \Exception("Column with name '" . $column->getName() . "' already exists in file " . __FILE__ . " on line " . __LINE__);
			}
		}
		$this->columns->add($column, $position);

	}

	public function setOptions(array $options)
	{
		if (isset($options["hideTablehead"]))
		{
			$this->setHideTablehead($options["hideTablehead"]);
		}

		if (isset($options["columns"]))
		{
			$columns = $options["columns"];
			foreach ($columns as $columnArray)
			{
				$column = new Column();
				$column->setAttributes($columnArray);
				$this->addColumn($column);
			}
			unset($options["columns"]);
		}

		if (isset($options["tableAttributes"]))
		{
			$this->setTableAttributes($options["tableAttributes"]);
		}
		if (isset($options["id"]))
		{
			$this->setId($options["id"]);
		}
		if (isset($options["sortable"]))
		{
			$this->setSortable($options["sortable"]);
		}
		if (isset($options["paginate"]))
		{
			$this->setPaginate($options["paginate"]);
		}
		if (isset($options["scrollY"]))
		{
			$this->setScrollY($options["scrollY"]);
		}
		isset($options["routeName"]) && $this->setRouteName($options["routeName"]);
		isset($options["routeStaticParams"]) && $this->setRouteStaticParams($options["routeStaticParams"]);
		isset($options["routeDynamicParams"]) && $this->setRouteDynamicParams($options["routeDynamicParams"]);
		isset($options["hasDefaultRoute"]) && $this->setHasDefaultRoute($options["hasDefaultRoute"]);
		isset($options["target"]) && $this->setTarget($options["target"]);

		isset($options["pageLength"]) && $this->setPageLength($options["pageLength"]);
		isset($options["lengthMenu"]) && $this->setLengthMenu($options["lengthMenu"]);
		isset($options["hideTablefoot"]) && $this->setHideTablehead($options["hideTablefoot"]);
	}

	public function setTableAttribute($name, $value)
	{
		if ($name == "id")
		{
			$this->setId($value);
		} else
		{
			$this->tableAttributes[$name] = $value;
		}
	}

	/**
	 * @return array
	 */
	public function getTableAttributes()
	{
		return $this->tableAttributes;
	}

	/**
	 * @param array $tableAttributes
	 */
	public function setTableAttributes($tableAttributes)
	{
		$this->tableAttributes = array();
		foreach ($tableAttributes as $key => $attribute)
		{
			$this->setTableAttribute($key, $attribute);
		}
	}

	/**
	 * @return boolean
	 */
	public function isHideTablehead()
	{
		return $this->hideTablehead;
	}

	/**
	 * @param boolean $hideTablehead
	 */
	public function setHideTablehead($hideTablehead)
	{
		$this->hideTablehead = ($hideTablehead == true);
	}

	/**
	 * @return boolean
	 */
	public function isHideTablefoot()
	{
		return $this->hideTablefoot;
	}

	/**
	 * @param boolean $hideTablefoot
	 */
	public function setHideTablefoot($hideTablefoot)
	{
		$this->hideTablefoot = ($hideTablefoot == true);
	}



	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return boolean
	 */
	public function isPaginate()
	{
		return $this->paginate;
	}

	/**
	 * @param boolean $paginate
	 */
	public function setPaginate($paginate)
	{
		$this->paginate = $paginate;
	}

	/**
	 * @return string
	 */
	public function getScrollY()
	{
		return $this->scrollY;
	}

	/**
	 * @param string $scrollY
	 */
	public function setScrollY($scrollY)
	{
		$this->scrollY = $scrollY;
	}

	/**
	 * @return array
	 */
	public function getRouteDynamicParams()
	{
		return $this->routeDynamicParams;
	}

	/**
	 * @param array $routeDynamicParams
	 */
	public function setRouteDynamicParams($routeDynamicParams)
	{
		$this->routeDynamicParams = $routeDynamicParams;
	}

	/**
	 * @return string
	 */
	public function getRouteName()
	{
		return $this->routeName;
	}

	/**
	 * @param string $routeName
	 */
	public function setRouteName($routeName)
	{
		$this->routeName = $routeName;
	}

	/**
	 * @return array
	 */
	public function getRouteStaticParams()
	{
		return $this->routeStaticParams;
	}

	/**
	 * @param array $routeStaticParams
	 */
	public function setRouteStaticParams($routeStaticParams)
	{
		$this->routeStaticParams = $routeStaticParams;
	}

	/**
	 * @return boolean
	 */
	public function isHasDefaultRoute()
	{
		return $this->hasDefaultRoute;
	}

	/**
	 * @param boolean $hasDefaultRoute
	 */
	public function setHasDefaultRoute($hasDefaultRoute)
	{
		$this->hasDefaultRoute = $hasDefaultRoute;
	}

	/**
	 * @return string
	 */
	public function getTarget()
	{
		return $this->target;
	}

	/**
	 * @param string $target
	 */
	public function setTarget($target)
	{
		$this->target = $target;
	}
}
