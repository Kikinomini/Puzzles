<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 09.06.16
 * Time: 12:14
 */

namespace BikeStore\View;


use Zend\View\Helper\AbstractHelper;
use Zend\View\Renderer\PhpRenderer;

class PriceHelper extends AbstractHelper
{
	public function __construct(/*PhpRenderer $phpRenderer*/)
	{
//		$this->phpRenderer = $phpRenderer;
	}

	public function __invoke($price = null, $withStar = false)
	{
		if ($price == null)
		{
			return $this;
		}
		return $this->formatPrice($price, $withStar);
	}

	public function formatPrice($price, $withStar = false)
	{
		return number_format((float)$price, 2, ",", ".")." €".(($withStar)?" *":"");
	}

	public function priceReference()
	{
		return "* Preis inklusive Mehrwertsteuer";
	}
}