<?php

namespace Shevsky\Discount4Review\Domain\Common\Settings\Storage;

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