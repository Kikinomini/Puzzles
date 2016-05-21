<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 11.02.15
 * Time: 17:19
 */

namespace Application\Model\Datatable\Column;
use Zend\View\Renderer\PhpRenderer;


/**
 * Class Column
 * @package Application\Model\Datatable
 */
class Column
{
	const TYPE_ROUTE = "route";
	const TYPE_DEFAULT = "default";

	/**
	 * @var bool
	 */
	private $hidden;

	/**
	 * @var array
	 */
	private $attributes;

	private $name;

	private $id;

	private $label;

	private $type;

//	/** @var  Route */
//	private $route;

	/** @var  bool */
	private $sortable;

	private $width;

    /** @var  bool */
    private $escapeHtml;

	/** @var  bool */
	private $escapeHtmlHead;

	/** @var  PhpRenderer */
	protected $phpRenderer;

	/** @var  bool */
	private $hasDefaultRoute;

	private $routeName;
	private $routeStaticParams;
	private $routeDynamicParams;
	private $target;

	public function __construct($name = "", $options = array())
	{
		$this->routeName = "";
		$this->routeDynamicParams = array();
		$this->routeStaticParams = array();
		$this->hasDefaultRoute = false;

		$this->escapeHtml = true;
        $this->escapeHtmlHead = true;
		$this->hidden = false;
		$this->attributes = array();
		$this->name = $name;
		$this->id = $name;
		$this->label = $name;
		$this->type = self::TYPE_DEFAULT;
		$this->width = "*";
		$this->setSortable(true);
		$this->setOptions($options);
		$this->phpRenderer = null;
		$this->target = "_self";

	}

	public function quote($string)
	{
		return "\"".$string."\"";
	}

	public function prepare(PhpRenderer $phpRenderer)
	{
		$this->phpRenderer = $phpRenderer;
		if ($this->isHidden() && !$this->hasClass("hidden")) {
			$this->addClass("hidden");
		}
	}

	private function escapeValue($value)
	{
		if ($this->phpRenderer != null)
		{
			return $this->phpRenderer->escapeHtml($value);
		}
		return $value;
	}

	public function hasClass($class)
	{
		return isset($this->attributes) && isset($this->attributes["class"]) && (in_array($class, explode(" ", $this->attributes["class"])));
	}

	public function buildJsArray()
	{
		$array = array(
			"bSortable" => ($this->isSortable())?"true":"false",
			"sType" => $this->quote($this->getType()),
			"width" => $this->quote($this->getWidth()),
		);
		return $array;
	}

	public function buildHeadCell()
	{
		$headCell = "<th ";
		foreach ($this->getAttributes() as $name => $attribute) {
			$headCell .= " " . $name . " = '" . $attribute . "' ";
		}
		$label = $this->getLabel();
		if ($this->isEscapeHtmlHead())
		{
			$label = $this->escapeValue($label);
		}
		$headCell .= ">".$label."</th>";

		return $headCell;
	}

	public function buildCell($row, $index)
	{
		$cell = "<td id = '".$this->getId()."__".$index."' ";
		foreach ($this->attributes as $urlParam => $attribute)
		{
			$cell .= " ".$urlParam." = '".$attribute."' '";
		}
		$value = $row[$this->getName()];
		if ($this->isEscapeHtml())
		{
			$value = $this->escapeValue($value);
		}

		$cell .= ">";
		if ($this->isHasDefaultRoute())
		{
			$dynamicParams = $this->getRouteDynamicParams();
			$params = $this->getRouteStaticParams();

			foreach ($dynamicParams as $urlParam => $datatableFieldName)
			{
				$params[$urlParam] = $row[$datatableFieldName];
			}
			$cell .= "<a class = 'hiddenLink totallyHidden maxWidth maxHeight' target='".$this->getTarget()."' href = '" . $this->phpRenderer->url($this->getRouteName(), $params) . "'><div class = 'maxWidth maxHeight'>" . $value . "</div></a>";
		}
		else
		{
			$cell .= $value;
		}
		$cell .= "</td>";
		return $cell;
	}

	public function setOptions(array $options)
	{
		if (isset($options["name"]))
		{
			$this->setName($options["name"]);
		}
		if (isset($options["id"]))
		{
			$this->setId($options["id"]);
		}
		if (isset($options["hidden"]))
		{
			$this->setHidden($options["hidden"]);
		}
		if (isset($options["label"]))
		{
			$this->setLabel($options["label"]);
		}
		if (isset($options["type"]))
		{
			$this->setType($options["type"]);
		}
//		if (isset($options["route"]))
//		{
//			$this->setRoute($options["route"]);
//		}
		if (isset($options["width"]))
		{
			$this->setWidth($options["width"]);
		}

        isset($options["escapeHtml"]) && $this->setEscapeHtml($options["escapeHtml"]);
        isset($options["attributes"]) && $this->setAttributes($options["attributes"]);
        isset($options["sortable"]) && $this->setSortable($options["sortable"]);
        isset($options["escapeHtmlHead"]) && $this->setEscapeHtmlHead($options["escapeHtmlHead"]);

		isset($options["routeName"]) && $this->setRouteName($options["routeName"]);
		isset($options["routeStaticParams"]) && $this->setRouteStaticParams($options["routeStaticParams"]);
		isset($options["routeDynamicParams"]) && $this->setRouteDynamicParams($options["routeDynamicParams"]);
		isset($options["hasDefaultRoute"]) && $this->setHasDefaultRoute($options["hasDefaultRoute"]);
		isset($options["target"]) && $this->setTarget($options["target"]);
	}

	/**
	 * @return boolean
	 */
	public function isEscapeHtmlHead()
	{
		return $this->escapeHtmlHead;
	}

	/**
	 * @param boolean $escapeHtmlHead
	 */
	public function setEscapeHtmlHead($escapeHtmlHead)
	{
		$this->escapeHtmlHead = $escapeHtmlHead;
	}

	/**
	 * @return boolean
	 */
	public function isHidden()
	{
		return $this->hidden;
	}

	/**
	 * @param boolean $hidden
	 */
	public function setHidden($hidden)
	{
		$this->hidden = ($hidden == true); //wandelt alles in boolscheWerte um
	}

	/**
	 * @return array
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}

	/**
	 * @param array $attributes
	 */
	public function setAttributes(array $attributes)
	{
		$this->attributes = array();
		foreach ($attributes as $key => $value)
		{
			$this->setAttribute($key, $value);
		}
	}

	public function setAttribute($name, $value)
	{
		{
			$this->attributes[$name] = $value;
		}
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
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
	 * @return mixed
	 */
	public function getLabel()
	{
		return $this->label;
	}

	/**
	 * @param mixed $label
	 */
	public function setLabel($label)
	{
		$this->label = $label;
	}

	/**
	 * @return mixed
	 */
	public function getWidth()
	{
		return $this->width;
	}

	/**
	 * @param mixed $width
	 */
	public function setWidth($width)
	{
		$this->width = $width;
	}

	/**
	 * @return mixed
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param mixed $type
	 */
	public function setType($type)
	{
		$this->type = $type;
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
		$this->sortable = $sortable;
	}

	public function addClass($className)
	{
		if (isset($this->attributes) && isset($this->attributes["class"]))
		{
			$this->attributes["class"] .= " ".$className;
		}
		else
		{
			$this->attributes["class"] = $className;
		}
	}

    /**
     * @return boolean
     */
    public function isEscapeHtml()
    {
        return $this->escapeHtml;
    }

    /**
     * @param boolean $escapeHtml
     */
    public function setEscapeHtml($escapeHtml)
    {
        $this->escapeHtml = $escapeHtml;
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
		$this->hasDefaultRoute = ($hasDefaultRoute == true);
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