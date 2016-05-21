<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 21.02.15
 * Time: 14:45
 */

namespace Application\Model\Datatable;


class ReorderDatatable extends Datatable
{
	private $reorderRouteName;
	private $reorderRouteParams;
	private $requestType;

	public function __construct($id, $options = array())
	{
		$this->setReorderRouteName("");
		$this->setReorderRouteParams(array());
		$this->setRequestType("POST");

		parent::__construct($id, $options);
		$this->setSortable(false);
	}

	protected function buildJsAdditionalFunctions()
	{
		$id = $this->getId();
		$url = $this->phpRenderer->url($this->getReorderRouteName(), $this->getReorderRouteParams());
		$requestType = $this->getRequestType();

		$script = <<<JS
	$("#$id").rowReordering({
		sURL: "$url",
		sRequestType: "$requestType"
	});
JS;
		return $script;
	}


	public function setOptions(array $options)
	{
		if (isset($options["reorderRouteName"]))
		{
			$this->setReorderRouteName($options["reorderRouteName"]);
		}
		if (isset($options["reorderRouteParams"]))
		{
			$this->setReorderRouteParams($options["reorderRouteParams"]);
		}
		if (isset($options["requesetType"]))
		{
			$this->setRequestType($options["reorderUrl"]);
		}
		parent::setOptions($options);
	}

	/**
	 * @return mixed
	 */
	public function getReorderRouteName()
	{
		return $this->reorderRouteName;
	}

	/**
	 * @param mixed $reorderRouteName
	 */
	public function setReorderRouteName($reorderRouteName)
	{
		$this->reorderRouteName = $reorderRouteName;
	}

	/**
	 * @return mixed
	 */
	public function getReorderRouteParams()
	{
		return $this->reorderRouteParams;
	}

	/**
	 * @param mixed $reorderRouteParams
	 */
	public function setReorderRouteParams(array $reorderRouteParams)
	{
		$this->reorderRouteParams = $reorderRouteParams;
	}

	/**
	 * @return mixed
	 */
	public function getRequestType()
	{
		return $this->requestType;
	}

	/**
	 * @param mixed $requestType
	 */
	public function setRequestType($requestType)
	{
		$this->requestType = $requestType;
	}



} 