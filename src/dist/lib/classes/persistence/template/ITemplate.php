<?php

namespace Shevsky\Discount4Review\Persistence\Template;

interface ITemplate
{
	/**
	 * @return string
	 */
	public function read();

	/**
	 * @param string $value
	 */
	public function write($value);

	/**
	 * @param mixed[] $vars
	 */
	public function assign(array $vars);

	/**
	 * @return string
	 */
	public function render();
}