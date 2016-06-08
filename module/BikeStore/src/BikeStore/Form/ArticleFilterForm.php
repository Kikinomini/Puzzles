<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 07.06.16
 * Time: 17:52
 */

namespace BikeStore\Form;

use Application\Form\MyForm;
use Zend\Form\Element;
use Zend\Form\Element\Number;
use Zend\Form\Element\Submit;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class ArticleFilterForm extends MyForm
{
	public function __construct(FlashMessenger $flashMessenger = null, $name = null, array $options = array())
	{
		parent::__construct($flashMessenger, $name, $options);
		$this->setAttribute("method", "GET");
		$this->setAttribute("class", "filterForm");
	}

	public function addElements()
	{
		$sideNumber = new Element\Hidden("page");
		$this->add($sideNumber);

		$searchText = new Element\Hidden("search");
		$this->add($searchText);

		$priceMin = new Number("priceMin");
		$priceMin->setLabel("Von:");
		$priceMin->setAttribute("step", "0.01");
		$this->add($priceMin);

		$priceMax = new Number("priceMax");
		$priceMax->setLabel("Bis:");
		$priceMax->setAttribute("step", "0.01");
		$this->add($priceMax);

		$priceSubmitButton = new Submit("priceSubmitButton");
		$priceSubmitButton->setLabel("&nbsp;");
		$priceSubmitButton->setValue(">>");
		$priceSubmitButton->setLabelOption('disable_html_escape', true);
		$this->add($priceSubmitButton);
	}

	public function add($elementOrFieldset, array $flags = array())
	{
		if ($elementOrFieldset instanceof Element) {
			if (!$elementOrFieldset->hasAttribute("required")) {
				$elementOrFieldset->setAttribute("required", false);
			}
		}
		return parent::add($elementOrFieldset, $flags);
	}
}