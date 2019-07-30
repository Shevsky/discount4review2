<?php

namespace Shevsky\Discount4Review\Domain\Wa\AssetDomain;

use Shevsky\Discount4Review\Domain\Wa\AssetPersistence\CSSAsset;

class MyOrderCSSAsset extends CSSAsset
{
	/**
	 * @return string
	 */
	public function getUrl()
	{
		return 'css/frontend/my_order.css';
	}
}