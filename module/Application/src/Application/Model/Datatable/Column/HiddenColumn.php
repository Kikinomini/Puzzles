<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 18.02.15
 * Time: 19:39
 */

namespace Application\Model\Datatable\Column;


class HiddenColumn extends Column
{
	public function __construct($name = "", $options = array())
	{
		parent::__construct($name, $options);
		$this->setHidden(true);
		$this->setSortable(false);
		$this->setWidth("0px");
	}
}