<?php

class Expression
{

	protected $expression = '';
	protected $delimiter = '/';

	public function __construct($delimiter = null)
	{
		if ($delimiter)
		{
			$this->delimiter = $delimiter;
		}
	}

	public static function make($delimiter = null)
	{
		return new static($delimiter);
	}


	public function find($value)
	{
		$value = $this->sanitize($value);

		return $this->add($value);
	}


	public function also($value)
	{
		return $this->find($value);
	}


	public function anything()
	{
		return $this->add('.*');
	}


	public function optional($value)
	{
		$value = $this->sanitize($value);

		return $this->add('(?:' . $value . ')?');
	}


	public function exclude($value)
	{
		$value = $this->sanitize($value);

		return $this->add("(?!$value).*?");
	}


	public function __toString()
	{
		return $this->getRegExp();
	}


	public function test($value)
	{
		var_dump($this->getRegExp()); // To Remove

		return (bool) preg_match($this->getRegExp(), $value);
	}

	/**
	 * @return string
	 */
	public function getRegExp()
	{
		return $this->delimiter . $this->expression . $this->delimiter;
	}


	protected function add($value)
	{
		$this->expression .= $value;

		return $this;
	}

	/**
	 * @param $value
	 * @return string
	 */
	protected function sanitize($value)
	{
	    return preg_quote($value, $this->delimiter);
	}
}