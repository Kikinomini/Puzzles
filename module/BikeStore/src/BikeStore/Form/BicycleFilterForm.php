<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 07.06.16
 * Time: 17:18
 */

namespace BikeStore\Form;


use Application\Form\MyForm;
use Application\Model\Form\Element\MyMultiCheckbox;
use Zend\Form\Element\Number;

class BicycleFilterForm extends MyForm
{
	public function addElements()
	{
		$frameType = new MyMultiCheckbox("frameType");
		$this->add($frameType);

		$riderType = new MyMultiCheckbox("riderType");
		$this->add($riderType);

		$frameHeightMin = new Number("frameHeightMin");
		$this->add($frameHeightMin);

		$frameHeightMax = new Number("frameHeightMax");
		$this->add($frameHeightMax);

		$priceMin = new Number("priceMin");
		$this->add($priceMin);

		$priceMax = new Number("priceMax");
		$this->add($priceMax);
	}
}