<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 22.02.15
 * Time: 13:37
 */

namespace Application\Model\Datatable\Column;


class RouteConfirmColumn extends RouteColumn
{
	private $confirmDialogTitleText;
	private $confirmDialogQuestionText;
	private $confirmDialogYesButtonText;
	private $confirmDialogNoButtonText;

	public function __construct($name = "", $options = array())
	{
		$this->setConfirmDialogTitleText("title");
		$this->setConfirmDialogQuestionText("question?");
		$this->setConfirmDialogYesButtonText("Ok");
		$this->setConfirmDialogNoButtonText("Abbrechen");
		parent::__construct($name, $options);
	}

	public function buildJsArray()
	{
		$array = parent::buildJsArray(); // TODO: Change the autogenerated stub
		$label = $this->getRouteLabel();
		$title = $this->getConfirmDialogTitleText();
		$question = $this->getConfirmDialogQuestionText();
		$confirmButton = $this->getConfirmDialogYesButtonText();
		$cancelButton = $this->getConfirmDialogNoButtonText();
		$array["mRender"] = <<<JS
	function(url, type, full) {
		return '<a class = "btn btn-xs btn-default" onclick = "myDatatable.confirmDialog(\'$title\',\'$question\', \''+url+'\', \'$confirmButton\', \'$cancelButton\' )">$label</a>';
	}
JS;
		return $array;
	}


	public function setOptions(array $options)
	{
		if (isset($options["confirmDialogTitleText"]))
		{
			$this->setConfirmDialogTitleText($options["confirmDialogTitleText"]);
		}
		if (isset($options["confirmDialogQuestionText"]))
		{
			$this->setConfirmDialogTitleText($options["confirmDialogQuestionText"]);
		}
		if (isset($options["confirmDialogYesButtonText"]))
		{
			$this->setConfirmDialogTitleText($options["confirmDialogYesButtonText"]);
		}
		if (isset($options["confirmDialogNoButtonText"]))
		{
			$this->setConfirmDialogTitleText($options["confirmDialogNoButtonText"]);
		}
		parent::setOptions($options);
	}


	/**
	 * @return mixed
	 */
	public function getConfirmDialogNoButtonText()
	{
		return $this->confirmDialogNoButtonText;
	}

	/**
	 * @param mixed $confirmDialogNoButtonText
	 */
	public function setConfirmDialogNoButtonText($confirmDialogNoButtonText)
	{
		$this->confirmDialogNoButtonText = $confirmDialogNoButtonText;
	}

	/**
	 * @return mixed
	 */
	public function getConfirmDialogQuestionText()
	{
		return $this->confirmDialogQuestionText;
	}

	/**
	 * @param mixed $confirmDialogQuestionText
	 */
	public function setConfirmDialogQuestionText($confirmDialogQuestionText)
	{
		$this->confirmDialogQuestionText = $confirmDialogQuestionText;
	}

	/**
	 * @return mixed
	 */
	public function getConfirmDialogTitleText()
	{
		return $this->confirmDialogTitleText;
	}

	/**
	 * @param mixed $confirmDialogTitleText
	 */
	public function setConfirmDialogTitleText($confirmDialogTitleText)
	{
		$this->confirmDialogTitleText = $confirmDialogTitleText;
	}

	/**
	 * @return mixed
	 */
	public function getConfirmDialogYesButtonText()
	{
		return $this->confirmDialogYesButtonText;
	}

	/**
	 * @param mixed $confirmDialogYesButtonText
	 */
	public function setConfirmDialogYesButtonText($confirmDialogYesButtonText)
	{
		$this->confirmDialogYesButtonText = $confirmDialogYesButtonText;
	}


} 