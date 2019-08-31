<?php

namespace Shevsky\Discount4Review\Domain\Wa\IntegrationDomain;

use Shevsky\Discount4Review\Domain\Wa\IntegrationPersistence\PluginIntegration;

class FlexDiscountIntegration extends PluginIntegration
{
	/**
	 * @return string
	 */
	protected function getAppId()
	{
		return 'shop';
	}

	/**
	 * @return string
	 */
	protected function getPluginId()
	{
		return 'flexdiscount';
	}
}