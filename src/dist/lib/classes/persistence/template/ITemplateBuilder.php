<?php

namespace Shevsky\Discount4Review\Persistence\Template;

interface ITemplateBuilder
{
	/**
	 * @param mixed[] $vars
	 */
	public function build(array $vars = []);

	/**
	 * @return string
	 */
	public function render();
}