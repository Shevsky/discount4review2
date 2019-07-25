<?php

namespace Shevsky\Discount4Review\Domain\Wa\AssetPersistence;

abstract class CSSAsset extends Asset
{
	/**
	 * @return string
	 */
	public function getExtension()
	{
		return 'css';
	}
}