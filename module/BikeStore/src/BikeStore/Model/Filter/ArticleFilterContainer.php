<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 08.06.16
 * Time: 08:52
 */

namespace BikeStore\Model\Filter;


class ArticleFilterContainer
{
	private $priceMin = null;
	private $priceMax = null;
	private $searchWords = array();

	private $caseSensitive = false;
	private $offset = 0;
	private $limit = null;

	private $result = null;
	private $numberResultsWithoutLimitOffset = 0;

	/**
	 * @return mixed
	 */
	public function getPriceMin()
	{
		return $this->priceMin;
	}

	/**
	 * @param mixed $priceMin
	 */
	public function setPriceMin($priceMin)
	{
		if(is_float($priceMin))
		{
			$this->priceMin = round($priceMin, 2);
		}
	}

	/**
	 * @return mixed
	 */
	public function getPriceMax()
	{
		return $this->priceMax;
	}

	/**
	 * @param mixed $priceMax
	 */
	public function setPriceMax($priceMax)
	{
		if(is_float($priceMax))
		{
			$this->priceMax = round($priceMax, 2);
		}
	}

	/**
	 * @return int
	 */
	public function getOffset()
	{
		return $this->offset;
	}

	/**
	 * @param int $offset
	 */
	public function setOffset($offset)
	{
		if(is_int($offset))
		{
			$this->offset = $offset;
		}
	}

	/**
	 * @return null
	 */
	public function getLimit()
	{
		return $this->limit;
	}

	/**
	 * @param null $limit
	 */
	public function setLimit($limit)
	{
		if(is_int($limit))
		{
			$this->limit = $limit;
		}
	}

	/**
	 * @return array
	 */
	public function getSearchWords()
	{
		if (!$this->caseSensitive)
		{
			foreach($this->searchWords as &$searchWord)
			{
				$searchWord = strtolower($searchWord);
			}
		}
		return $this->searchWords;
	}

	/**
	 * @param array $searchWords
	 */
	public function setSearchWords($searchWords)
	{
		if (is_string($searchWords))
		{
			$searchWords = explode(" ", $searchWords);
		}
		if (is_array($searchWords))
		{
			$this->searchWords = array();
			foreach($searchWords as $searchWord)
			{
				$this->addSearchWord($searchWord);
			}
		}
	}

	public function addSearchWord($searchWord)
	{
		if (is_string($searchWord))
		{
			$this->searchWords[] = $searchWord;
		}
	}

	/**
	 * @return boolean
	 */
	public function isCaseSensitive()
	{
		return $this->caseSensitive;
	}

	/**
	 * @param boolean $caseSensitive
	 */
	public function setCaseSensitive($caseSensitive)
	{
		$this->caseSensitive = $caseSensitive;
	}
	

	public function isPriceMinSet()
	{
		return ($this->priceMin != null && $this->priceMin > 0);
	}

	public function isPriceMaxSet()
	{
		return ($this->priceMax != null && $this->priceMax > 0);
	}

	/**
	 * @return null
	 */
	public function getResult()
	{
		return $this->result;
	}

	/**
	 * @param null $result
	 */
	public function setResult($result)
	{
		$this->result = $result;
	}

	/**
	 * @return int
	 */
	public function getNumberResultsWithoutLimitOffset()
	{
		return $this->numberResultsWithoutLimitOffset;
	}

	/**
	 * @param int $numberResultsWithoutLimitOffset
	 */
	public function setNumberResultsWithoutLimitOffset($numberResultsWithoutLimitOffset)
	{
		$this->numberResultsWithoutLimitOffset = $numberResultsWithoutLimitOffset;
	}

	public function getNumberResults()
	{
		return count($this->result);
	}
}