<?php

namespace Shevsky\Discount4Review\Service;

use Shevsky\Discount4Review\Domain\Common\SettingsStorage\BasicSettingsStorage;
use Shevsky\Discount4Review\Domain\Common\SettingsStorage\StorefrontSettingsStorage;
use Shevsky\Discount4Review\Domain\Wa\Env\Env;
use Shevsky\Discount4Review\Persistence\Settings\ISettingsItem;

class SettingsService
{
	public $basic;
	public $storefront;

	private $env;

	/**
	 * @param Env $env
	 * @param BasicSettingsStorage $basic_settings_storage
	 * @param StorefrontSettingsStorage $storefront_settings_storage
	 */
	public function __construct(Env $env, BasicSettingsStorage $basic_settings_storage, StorefrontSettingsStorage $storefront_settings_storage)
	{
		$this->env = $env;

		$this->basic = $basic_settings_storage;
		$this->basic->setSettingsService($this);

		$this->storefront = $storefront_settings_storage;
		$this->storefront->setSettingsService($this);
	}

	/**
	 * @param ISettingsItem $setting
	 * @return mixed
	 */
	public function readForTheme(ISettingsItem $setting)
	{
		$value = $setting->getSpecific($this->env->getCurrentTheme()->getId());
		if ($value !== null)
		{
			return $value;
		}

		return $setting->getGeneral();
	}

	/**
	 * @param ISettingsItem $setting
	 * @return mixed
	 */
	public function readForStorefront(ISettingsItem $setting)
	{
		$value = $setting->getSpecific($this->env->getCurrentStorefront()->getId());
		if ($value !== null)
		{
			return $value;
		}

		return $setting->getGeneral();
	}
}