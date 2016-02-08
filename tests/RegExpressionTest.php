<?php

class RegExpressionTest extends PHPUnit_Framework_TestCase
{

	/** @test */
	public function it_finds_a_string()
	{

		$regExp = RegExpression::make()->find('www');

		$this->assertTrue($regExp->test('www'));

		$regExp = RegExpression::make()->also('www');
		$this->assertTrue($regExp->test('www'));

	}

	/** @test */
	public function it_checks_for_anything()
	{

		$regExp = RegExpression::make()->anything();

		$this->assertTrue($regExp->test('foo'));

	}

	/** @test */
	public function it_can_have_a_value_or_not()
	{
		$regExp = RegExpression::make()->optional('http');

		$this->assertTrue($regExp->test('http'));
		$this->assertTrue($regExp->test(''));
	}

	/** @test */
	public function it_can_chain_method_calls()
	{
		$regExp = RegExpression::make()->find('www')->optional('.')->also('laravel');

		$this->assertTrue($regExp->test('www.laravel'));
		$this->assertFalse($regExp->test('wwwXlaravel'));
	}

	/** @test */
	public function it_can_test_itself()
	{
		$regExp = RegExpression::make()->find('foo')->optional('bar')->also('baz');

		$this->assertTrue($regExp->test('foobarbaz'));
	}


	/** @test */
	public function it_can_exclude_values()
	{
		$regExp = RegExpression::make()
				->find('foo')
				->exclude('bar')
				->also('BAZ');

		$this->assertTrue($regExp->test('fooRARBAZ'));
		$this->assertFalse($regExp->test('foobarBAZ'));
	}
	


	/** @test */
	public function it_can_catch_a_link()
	{
	    $regExp = RegExpression::make('i')->catchLink();

		$this->assertTrue($regExp->test('@FUCKER'));
		$this->assertFalse($regExp->test('de#fsfsf.ui'));
	}




	/** @test */
	public function it_can_select_only_if_expression_is_followed_by_symbol()
	{
		$regExp = RegExpression::make('i')->find('google')->ifFollowedBySymbol('<');

		$this->assertTrue($regExp->test('<a>google</a>'));

		$this->assertFalse($regExp->test('google'));

		$this->assertTrue($regExp->test('<a>Google</a>'));

		$this->setExpectedException('Exception');
		$regExp = RegExpression::make()->find('google')->ifFollowedBySymbol('<a>');
	}


	/** @test */
	public function it_can_select_only_if_expression_is_preceeded_with_sybol()
	{
		$regExp = RegExpression::make()->ifPreceededWithSymbol('\$')->find('VARIABLE');

		$this->assertTrue($regExp->test('this is $VARIABLE'));

		$this->assertFalse($regExp->test('this is @VARIABLE'));
	}

}