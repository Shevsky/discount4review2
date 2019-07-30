<?php

namespace Shevsky\Discount4Review\Domain\Wa\TemplateBuilderDomain;

use Shevsky\Discount4Review\Domain\Wa\TemplateBuilderPersistence\TemplateBuilder;
use shopCategoryModel;

class MyOrderTemplateBuilder extends TemplateBuilder
{
	/**
	 * @param mixed[] $vars
	 */
	public function build(array $vars = [])
	{
		$vars = array_merge(
			$vars,
			[

			]
		);

		$this->template->assign($vars);
	}
}