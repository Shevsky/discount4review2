<?php

namespace Shevsky\Discount4Review\Domain\Wa\AssetDomain;

use Shevsky\Discount4Review\Domain\Wa\AssetPersistence\JSAsset;

class MyOrderJSAsset extends JSAsset
{
	/**
	 * @return string
	 */
	public function getUrl()
	{
		return 'js/frontend/field.js';
	}
}