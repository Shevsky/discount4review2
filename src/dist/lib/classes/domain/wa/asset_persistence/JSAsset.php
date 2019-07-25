<?php

namespace Shevsky\Discount4Review\Domain\Wa\AssetPersistence;

abstract class JSAsset extends Asset
{
	/**
	 * @return string
	 */
	public function getExtension()
	{
		return 'js';
	}
}