<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 28.01.15
 * Time: 18:54
 */

namespace Application\View\Helper;

use Application\Model\Form\Element\MyMultiCheckbox;
use Zend\Form\Element;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Renderer\PhpRenderer;

class MyFormHelper extends AbstractHelper
{
	/** @var  PhpRenderer */
	private $phpRenderer;

	private $showLabels;

	public function __construct(PhpRenderer $phpRenderer)
	{
		$this->phpRenderer = $phpRenderer;
		$this->showLabels = true;
	}

	public function __invoke(Form $form = null, $columns = 1, $renderType = "table")
	{
		if($form == null)
		{
			return $this;
		}
		$this->showLabels = ($form->getAttribute("showLabels") === null || $form->getAttribute("showLabels") == true);

		if($renderType == "inline")
		{
			$renderString = $this->renderInline($form);
		}
		elseif($renderType == "inlineFullWidth")
		{
			$renderString = $this->renderInline($form, true);
		}
		elseif($renderType == "tableTransferClasses")
		{
			$renderString = $this->renderTable($form, $columns, true);
		}
		else
		{
			$renderString = $this->renderTable($form, $columns);
		}

		return $this->phpRenderer->form()->openTag($form) . $renderString . $this->phpRenderer->form()->closeTag();
	}

	private function renderInline($form, $renderFullWidth = false)
	{
		$elements = $form->getElements();
		$renderString = "";
		if($renderFullWidth)
		{
			$renderString .= "<table class = 'maxWidth'><tr>";
		}
		foreach($elements as $element)
		{
			if($renderFullWidth)
			{
				$renderString .= "<td>" . $this->render($element, false) . "</td>";
			}
			else
			{
				$renderString .= $this->render($element, false) . " ";
			}
		}
		if($renderFullWidth)
		{
			$renderString .= "</tr><table>";
		}
		return $renderString;
	}

	private function renderTable(Form $form, $columns, $transferClasses = false)
	{
		$elements = $form->getElements();

		$renderString = "<tr>";
		$n = 0;
		/** @var Element $element */
		foreach($elements as $element)
		{
			if($n % $columns == 0 && $n > 0)
			{
				$renderString .= "</tr><tr>";
			}
			($transferClasses) ? $classes = $element->getAttribute("class") : $classes = '';
			$renderString .= "<td class = '$classes'>" . $this->render($element, $transferClasses) . "</td>";

			$n++;
		}
		$classes = $form->getAttribute("class");
		$tableHead = "<table class = 'table nolines nospace form $classes'>";
		$renderString .= "</tr></table>";
		return $tableHead . $renderString;
	}

	private function render(Element $element, $transferClasses)
	{
		($transferClasses) ? $classes = $element->getAttribute("class") : $classes = '';
		$renderedElement = "<div class = 'form-group $classes' >";
		if($element instanceof MyMultiCheckbox)
		{
			if($this->showLabels)
			{
				if(strlen($element->getLabel()) > 0)
				{
					$renderedElement .= "<label class = 'myMultiCheckboxHeadLabel' for = '" . $element->getName() .
										"__all'>" . $element->getLabel() . "</label>";
				}
				else
				{
					$renderedElement .= "<label class = 'myMultiCheckboxHeadLabel' >&nbsp;</label>";
				}
			}

			if($element->isShowCheckAll())
			{
				$checkbox = new Element\Checkbox($element->getName() . "__all");
				$checkbox->setUseHiddenElement(false);
//                $checkbox->setLabel($element->getLabel());
				$checkbox->setAttribute("title", "Alle");
				$checkbox->setAttribute("id", $element->getName() . "__all");
				$checkbox->setAttribute("class", "myMultiCheckboxHead");
				$renderedElement .= $this->render($checkbox, true);

				$this->phpRenderer->inlineScript()->captureStart();
				$id = $element->getName() . "__all";
				$name = $element->getName();
				echo <<<JS
                    $(document).ready(function () {
                        $("#$id").change(function (){
                            myForm.myMultiCheckbox_checkAll("$name");
                        });
                    });
JS;

				$this->phpRenderer->inlineScript()->captureEnd();
			}
			$renderedElement .= "<div class = 'myMultiCheckbox'>";
			$valueOptions = $element->getValueOptions();
			$checked = $element->getValue();
			foreach($valueOptions as $value => $label)
			{
				$checkbox = new Element\Checkbox($element->getName() . "[]");
				$checkbox->setUseHiddenElement(false);
				$checkbox->setLabel($label);
				$checkbox->setCheckedValue($value);
				$checkbox->setChecked(array_key_exists($value, $checked) && $checked[$value]);
				$renderedElement .= $this->render($checkbox, $transferClasses);
			}
			$renderedElement .= "</div>";
		}
		else
		{
			if($this->showLabels && !($element instanceof Element\Hidden))
			{
				if(strlen($element->getLabel()) > 0)
				{
					$renderedElement .= $this->phpRenderer->formLabel($element);
				}
				else
				{
					$renderedElement .= "<label>&nbsp;</label>";
				}
			}
			$renderedElement .= $this->phpRenderer->formElement($element);
		}
		$renderedElement .= "</div>";
		return $renderedElement;
	}

	/**
	 * @param Element\MultiCheckbox $multiCheckBox
	 * @return string
	 */
	public function multiCheckBox($multiCheckBox)
	{

		$renderedElement = "";
		if(strlen($multiCheckBox->getLabel()) > 0)
		{
//			$renderedElement .= "<label class = 'multiCheckBoxLabel' for = '" . $multiCheckBox->getName() . "__all'>" .	$multiCheckBox->getLabel() . "</label>";
			$renderedElement .= "<label class = 'multiCheckBoxLabel' >" .	$multiCheckBox->getLabel() . "</label>";
		}
		else
		{
//			$renderedElement .= "<label class = 'myMultiCheckboxHeadLabel' >&nbsp;</label>";
		}

		$renderedElement .= "<div class = 'multiCheckBoxBody'>";
		$valueOptions = $multiCheckBox->getValueOptions();
		$checkedElements = $multiCheckBox->getValue();
		foreach($valueOptions as $value => $label)
		{
			$checkbox = new Element\Checkbox($multiCheckBox->getName() . "[]");
			$checkbox->setUseHiddenElement(false);
			$checkbox->setLabel($label);
			$checkbox->setCheckedValue($value);
			$checkbox->setAttribute("class", $multiCheckBox->getAttribute("class"));
//			$checkbox->setChecked(array_key_exists($value, $checked) && $checked[$value]);
			$checkbox->setChecked(is_array($checkedElements) && in_array($value, $checkedElements));
			$renderedElement .= $this->phpRenderer->formRow($checkbox);
		}
		$renderedElement .= "</div>";
		return $renderedElement;
	}
}