<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 16.06.16
 * Time: 09:33
 */

namespace BikeStore\Form\InputFilter;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Between;
use Zend\Validator\Digits;

class ArticleInputFilter extends InputFilter
{
	/**
	 * ArticleInputFilter constructor.
	 */
	public function __construct()
	{
		$this->addPageInput();
		$this->addSearchInput();
		$this->addPriceMaxInput();
		$this->addPriceMinInput();
	}

	public function addPageInput()
	{
		$pageInput = new Input("page");
		$pageInput->setRequired(false);
		$pageInput->getValidatorChain()
			->attach(new Digits());
//			->attach(new Between(array(
//				"min" => 0,
//			)));
		$this->add($pageInput);
	}

	public function addSearchInput()
	{
		$searchInput = new Input("search");
		$searchInput->setRequired(false);
		$this->add($searchInput);
	}

	public function addPriceMinInput()
	{
		$priceMinInput = new Input("priceMin");
		$priceMinInput->setRequired(false);
		$this->add($priceMinInput);
	}

	public function addPriceMaxInput()
	{
		$priceMaxInput = new Input("priceMax");
		$priceMaxInput->setRequired(false);
		$this->add($priceMaxInput);
	}
}