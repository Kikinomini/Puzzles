<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 06.04.16
 * Time: 11:27
 */

namespace Application\Model;

use Traversable;

class MyArrayList implements \ArrayAccess, \Countable, \IteratorAggregate
{
	/** @var  array */
	protected $list;

	/**
	 * MyArrayList constructor.
	 * @param array $list
	 */
	public function __construct(array $list = array())
	{
		$this->list = $list;
	}


	public function offsetExists($offset)
	{
		if (!is_integer($offset))
		{
			return false;
		}
		return isset($this->list[$offset]);
	}

	public function offsetGet($offset)
	{
		return $this->offsetExists($offset) ? $this->data[$offset] : null;
	}

	public function offsetSet($offset, $value)
	{
		if (!$this->offsetExists($offset))
		{
			$this->list[] = $value;
		} else
		{
			$this->list[$offset] = $value;
		}
	}

	public function offsetUnset($offset)
	{
		if ($this->offsetExists($offset))
		{
			unset($this->list[$offset]);
		}
	}

	public function add($value, $position = -1)
	{
		if (is_integer($position)){
			if ($position < 0 || $position > count($this->list))
			{
				$this->offsetSet(null, $value);
			}
			else
			{
				$this->list = array_splice($this->list, $position, 0, array($value));
			}
		}
	}

	public function set($position, $value)
	{
		$this->offsetSet($position, $value);
	}

	public function get($position)
	{
		return $this->offsetGet($position);
	}

	public function indexOf($value)
	{
		return array_search($value, $this->list);
	}

	public function toArray()
	{
		return $this->list;
	}

	public function count()
	{
		return count($this->list);
	}

	public function getIterator()
	{
		return new \ArrayIterator($this->list);
	}
}