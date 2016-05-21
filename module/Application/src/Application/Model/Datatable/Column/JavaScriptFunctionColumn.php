<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 20.09.2015
 * Time: 13:05
 */

namespace Application\Model\Datatable\Column;

class JavaScriptFunctionColumn extends PictureEnumColumn //Für die Userverwaltung
{
	private $javaScriptFunctionName;

	public function __construct($name = "", $options = array())
	{
		$this->javaScriptFunctionName = NULL;
		parent::__construct($name, $options);
	}

	public function buildJsArray()
	{
		$javasScriptFunctionName = $this->getJavaScriptFunctionName();
		$array = parent::buildJsArray();
		$array["fnCreatedCell"] = <<<JS
 		function(nTd, sData, oData, iRow, iCol)
                {
                    $(nTd).first().click(function(){
                        $javasScriptFunctionName(iRow, iCol, nTd);
                    });
                }
JS;
		return $array;
	}


	public function setOptions(array $options)
	{
		parent::setOptions($options);

		isset($options["javaScriptFunctionName"]) && $this->setJavaScriptFunctionName($options["javaScriptFunctionName"]);
	}

	/**
	 * @return null
	 */
	public function getJavaScriptFunctionName()
	{
		return $this->javaScriptFunctionName;
	}

	/**
	 * @param null $javaScriptFunctionName
	 */
	public function setJavaScriptFunctionName($javaScriptFunctionName)
	{
		$this->javaScriptFunctionName = $javaScriptFunctionName;
	}


} 