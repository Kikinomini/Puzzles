<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 16.06.16
 * Time: 12:50
 */

namespace BikeStore\Form\InputFilter;

use Zend\InputFilter\Input;

class BicycleInputFilter extends ArticleInputFilter
{
	public function __construct()
	{
		parent::__construct();
		$this->addRiderTypeInput();
		$this->addFrameTypeInput();
		$this->addFrameHeightMaxInputType();
		$this->addFrameHeightMinInputType();
	}
	private function addFrameTypeInput()
	{
		$frameTypeInput = new Input("frameType");
		$frameTypeInput->setRequired(false);
		$this->add($frameTypeInput);
	}
	private function addRiderTypeInput()
	{
		$riderTypeInput = new Input("riderType");
		$riderTypeInput->setRequired(false);
		$this->add($riderTypeInput);
	}
	private function addFrameHeightMinInputType()
	{
		$frameHeightMinInput = new Input("frameHeightMin");
		$frameHeightMinInput->setRequired(false);
		$this->add($frameHeightMinInput);
	}
	private function addFrameHeightMaxInputType()
	{
		$frameHeightMaxInput = new Input("frameHeightMax");
		$frameHeightMaxInput->setRequired(false);
		$this->add($frameHeightMaxInput);
	}
}