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

	/**
	 * @return bool
	 */
	public function getMyOrderAutoInjectStatus()
	{
		return $this->readSettingForStorefront('my_order.auto_inject_status');
	}
}