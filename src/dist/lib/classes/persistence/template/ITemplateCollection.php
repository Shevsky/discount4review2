<?php

namespace Shevsky\Discount4Review\Persistence\Template;

interface ITemplateCollection
{
	/**
	 * @param string $name
	 * @return ITemplate
	 */
	public function getTemplate($name);
}