<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 18.02.15
 * Time: 19:46
 */

namespace Application\Model\Datatable\Column;


class RouteColumn extends Column
{
	private $routeName;
	private $routeStaticParams;
	private $routeDynamicParams;
	private $routeLabel;
    private $target;

	public function __construct($name = "", $options = array())
	{
		$this->routeName = "";
		$this->routeDynamicParams = array();
		$this->routeStaticParams = array();
		$this->routeLabel = "";
        $this->target = "_self";

		parent::__construct($name);
		$this->setLabel("");
		$this->setWidth("5%");

		$this->setOptions($options);
		$this->setSortable(false);
	}

	public function buildCell($row, $index)
	{
		$dynamicParams = $this->getRouteDynamicParams();
		$params = $this->getRouteStaticParams();

		foreach ($dynamicParams as $urlParam => $datatableFieldName) {
			$params[$urlParam] = $row[$datatableFieldName];
		}
		$row[$this->getName()] .= $this->phpRenderer->url($this->getRouteName(), $params);
		return parent::buildCell($row, $index);
	}

	public function buildJsArray()
	{
		$label = $this->getRouteLabel();
		$target = $this->getTarget();

		$array = parent::buildJsArray();
		$array["mRender"] = <<<JS
function(url, type, full) {
		return '<a class = "btn btn-xs btn-default" target = "$target" href="'+url+'">$label</a>';
	}

JS;
		return $array;
	}


	public function setOptions(array $options)
	{
		isset($options["routeName"]) && $this->setRouteName($options["routeName"]);
		isset($options["routeStaticParams"]) && $this->setRouteStaticParams($options["routeStaticParams"]);
		isset($options["routeDynamicParams"]) && $this->setRouteDynamicParams($options["routeDynamicParams"]);
		isset($options["routeLabel"]) && $this->setRouteLabel($options["routeLabel"]);
		isset($options["target"]) && $this->setTarget($options["target"]);

		parent::setOptions($options);
	}

	/**
	 * @return mixed
	 */
	public function getRouteDynamicParams()
	{
		return $this->routeDynamicParams;
	}

	/**
	 * @param mixed $routeDynamicParams
	 */
	public function setRouteDynamicParams($routeDynamicParams)
	{
		$this->routeDynamicParams = $routeDynamicParams;
	}

	/**
	 * @return mixed
	 */
	public function getRouteLabel()
	{
		return $this->routeLabel;
	}

	/**
	 * @param mixed $routeLabel
	 */
	public function setRouteLabel($routeLabel)
	{
		$this->routeLabel = $routeLabel;
	}

	/**
	 * @return mixed
	 */
	public function getRouteName()
	{
		return $this->routeName;
	}

	/**
	 * @param mixed $routeName
	 */
	public function setRouteName($routeName)
	{
		$this->routeName = $routeName;
	}

	/**
	 * @return mixed
	 */
	public function getRouteStaticParams()
	{
		return $this->routeStaticParams;
	}

	/**
	 * @param mixed $routeStaticParams
	 */
	public function setRouteStaticParams($routeStaticParams)
	{
		$this->routeStaticParams = $routeStaticParams;
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