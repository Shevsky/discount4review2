<?php

namespace Shevsky\Discount4Review\Domain\Common\SettingsStorage;

class StorefrontSettingsStorage extends CommonSettingsStorage
{
	/**
	 * @return string
	 */
	protected function getCase()
	{
		return 'storefront';
	}
}