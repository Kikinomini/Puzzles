<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 19.09.2015
 * Time: 17:18
 */

namespace Application\Model\Datatable\Column;

class PictureEnumColumn extends EnumColumn{
	public function buildJsArray()
	{
		$basePath = $this->phpRenderer->basePath();
		$array = parent::buildJsArray(); 
		$array["mRender"] = <<<JS
        function(value, type, full)
        {
            return "<img src = $basePath/images/"+value+" class = 'datatableImg'>";
        }
JS;
		return $array;
	}

} 