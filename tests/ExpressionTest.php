<?php

class ExpressionTest extends PHPUnit_Framework_TestCase
{

	/** @test */
	public function it_finds_a_string()
	{

		$regExp = Expression::make()->find('www');

		$this->assertTrue($regExp->test('www'));

		$regExp = Expression::make()->also('www');
		$this->assertTrue($regExp->test('www'));

	}

	/** @test */
	public function it_checks_for_anything()
	{

		$regExp = Expression::make()->anything();

		$this->assertTrue($regExp->test('foo'));

	}

	/** @test */
	public function it_can_have_a_value_or_not()
	{
		$regExp = Expression::make()->optional('http');

		$this->assertTrue($regExp->test('http'));
		$this->assertTrue($regExp->test(''));
	}

	/** @test */
	public function it_can_chain_method_calls()
	{
		$regExp = Expression::make()->find('www')->optional('.')->also('laravel');

		$this->assertTrue($regExp->test('www.laravel'));
		$this->assertFalse($regExp->test('wwwXlaravel'));
	}

	/** @test */
	public function it_can_test_itself()
	{
		$regExp = Expression::make()->find('foo')->optional('bar')->also('baz');

		$this->assertTrue($regExp->test('foobarbaz'));
	}


	/** @test */
	public function it_can_exclude_values()
	{
		$regExp = Expression::make()
				->find('foo')
				->exclude('bar')
				->also('BAZ');

		$this->assertTrue($regExp->test('fooRARBAZ'));
		$this->assertFalse($regExp->test('foobarBAZ'));
	}

}