<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 16.06.16
 * Time: 10:23
 */

namespace BikeStore\Form\InputFilter;

use Zend\InputFilter\Input;
use Zend\Validator\NotEmpty;

class BikePartInputFilter extends ArticleInputFilter
{
	public function __construct()
	{
		parent::__construct();
		$this->addEquipmentTypesInput();
	}
	private function addEquipmentTypesInput()
	{
		$equipmentTypesInput = new Input("equipmentTypes");
		$equipmentTypesInput->setRequired(false);
		$this->add($equipmentTypesInput);
	}
}