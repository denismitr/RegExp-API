<?php

class RegExpression
{

	protected $expression = '';
	protected $delimiter;
	protected $flags;

	protected $serviceSymbols = ['$', '.'];

	public function __construct($flags = '', $delimiter = '/')
	{
		$this->delimiter = $delimiter;
		$this->flags = $flags;
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



	public function oneOrMore()
	{
		return $this->add('+');
	}


	public function matchZeroOrOne()
	{
		return $this->add('?');
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


	public function catchLink($markSymbol = '@')
	{
		return $this->add('(' . $markSymbol . '\w+)');
	}


	public function ifFollowedBySymbol($symbol)
	{
	    $this->verifySymbol($symbol);

		return $this->add('(?=' . $symbol . ')');
	}



	public function ifNotFollowedBySymbol($symbol)
	{
		$this->verifySymbol($symbol);

		return $this->add('(?!' . $symbol . ')');
	}


	public function ifPreceededWithSymbol($symbol)
	{
		$this->verifySymbol($symbol);

		return $this->add('(?<=' . $symbol . ')');
	}



	public function ifNotPreceededWithSymbol($symbol)
	{
		$this->verifySymbol($symbol);

		return $this->add('(?<!' . $symbol . ')');
	}


	public function __toString()
	{
		return $this->getRegExp();
	}


	public function test($value)
	{
		var_dump($this->getRegExp()); /* TODO: To Remove */

		return (bool) preg_match($this->getRegExp(), $value);
	}

	/**
	 * @return string
	 */
	public function getRegExp()
	{
		return $this->delimiter . $this->expression . $this->delimiter . $this->flags;
	}


	protected function add($value)
	{
		$this->expression .= $value;

		return $this;
	}


	/**
	 * @param $symbol
	 * @throws Exception
	 */
	protected function verifySymbol($symbol)
	{
		$symbol = ltrim($symbol, '\\');

		if (strlen($symbol) !== 1)
		{
			throw new \Exception('Invalid argument ' . $symbol . ' has been passed. Char type is expected!');
		}
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