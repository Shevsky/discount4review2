<?php

namespace Shevsky\Discount4Review\Domain\Wa\IntegrationPersistence;

use Shevsky\Discount4Review\Persistence\Integration\IIntegration;

abstract class PluginIntegration implements IIntegration
{
	/**
	 * @return bool
	 */
	public function isAvailable()
	{
		if (!$this->hasOwnAvailability())
		{
			return $this->isInstall();
		}
		else
		{
			return $this->isInstall() && $this->getOwnAvailability();
		}
	}

	/**
	 * @return string
	 */
	abstract protected function getAppId();

	/**
	 * @return string
	 */
	abstract protected function getPluginId();

	/**
	 * @return bool
	 */
	protected function hasOwnAvailability()
	{
		return false;
	}

	/**
	 * @return bool
	 */
	protected function getOwnAvailability()
	{
		return false;
	}

	/**
	 * @return bool
	 */
	protected function isInstall()
	{
		$app_id = $this->getAppId();
		$plugin_id = $this->getPluginId();

		wa($app_id)->getConfig()->getPluginInfo($plugin_id);

		return !empty($plugin_info);
	}
}