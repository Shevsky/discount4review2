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
				'discount_value' => 5,
				'bonus_value' => 135,
				'count_for_discount' => 3,
				'count_for_discount_left' => 1,
				'count_for_discount_done' => 2,

			]
		);

		$this->template->assign($vars);
	}
}