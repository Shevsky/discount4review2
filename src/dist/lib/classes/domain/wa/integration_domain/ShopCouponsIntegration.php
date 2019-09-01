<?php

namespace Shevsky\Discount4Review\Domain\Wa\IntegrationDomain;

use Shevsky\Discount4Review\Persistence\Integration\IIntegration;
use waAppSettingsModel;

class ShopCouponsIntegration implements IIntegration
{
	/**
	 * @return bool
	 */
	public function isAvailable()
	{
		$app_settings_model = new waAppSettingsModel();

		return (bool)$app_settings_model->get('shop', 'discount_coupons');
	}
}