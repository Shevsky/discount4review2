<?php

namespace Shevsky\Discount4Review\Domain\Common\SettingsStorage;

use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Domain\Common\SettingsConfig\SettingsConfig;
use Shevsky\Discount4Review\Domain\Common\SettingsItem\SettingsItem;
use Shevsky\Discount4Review\Persistence\Access\ISettingsAccess;
use Shevsky\Discount4Review\Persistence\Settings\ISettingsItem;
use Shevsky\Discount4Review\Persistence\Settings\ISettingsStorage;
use Shevsky\Discount4Review\Util\SettingRetransformerUtil;
use Exception;

abstract class CommonSettingsStorage implements ISettingsStorage
{
	protected $access;

	private $setting_items = [];
	private $settings_config;

	/**
	 * @param ISettingsAccess $access
	 */
	public function __construct(ISettingsAccess $access)
	{
		$this->access = $access;
		$this->settings_config = new SettingsConfig($this->getConfigPath());
	}

	/**
	 * @return string
	 */
	abstract protected function getCase();

	/**
	 * @return string
	 */
	private function getConfigPath()
	{
		return Context::getCasePath() . "settings_config/{$this->getCase()}.php";
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasSetting($name)
	{
		return $this->settings_config->hasSetting($name);
	}

	/**
	 * @return ISettingsItem[] = [
	 *  $name => ISettingsItem
	 * ]
	 * @throws Exception
	 */
	public function getSettings()
	{
		$iterator = $this->settings_config->getIterator();
		foreach ($iterator as $name => $setting)
		{
			$this->getSetting($name);
		}

		return $this->setting_items;
	}

	/**
	 * @param string $name
	 * @return ISettingsItem
	 * @throws Exception
	 */
	public function getSetting($name)
	{
		if (!$this->settings_config->hasSetting($name))
		{
			throw new Exception("Не найдена настройка \"{$name}\"");
		}

		if (!array_key_exists($name, $this->setting_items))
		{
			$setting_config = $this->settings_config->getSetting($name);

			$values = $this->access->readSetting($name);
			if (!array_key_exists('*', $values))
			{
				$values['*'] = $setting_config->getDefaultValue();
			}

			$setting = new SettingsItem($name, $values, $setting_config->getType());

			$this->setting_items[$name] = $setting;
		}

		return $this->setting_items[$name];
	}

	/**
	 * @param string $name
	 * @param ISettingsItem $setting
	 * @throws Exception
	 */
	public function setSetting($name, ISettingsItem $setting)
	{
		if (!$this->settings_config->hasSetting($name))
		{
			throw new Exception("Не найдена настройка \"{$name}\"");
		}

		$setting_config = $this->settings_config->getSetting($name);

		foreach ($setting->getIterator() as $id => $value)
		{
			$value = SettingRetransformerUtil::retransform($value, $setting_config->getType());

			$this->access->writeSetting(
				$name,
				[
					$id => $value,
				]
			);
		}

		$this->setting_items[$name] = $setting;
	}

	/**
	 * @return array[] = [
	 *  $name => [
	 *      '*' => mixed,
	 *      $id => mixed
	 *  ]
	 * ]
	 * @throws Exception
	 */
	public function toArray()
	{
		$settings = $this->getSettings();

		return array_map(
			function($setting) {
				/**
				 * @var ISettingsItem $setting
				 */

				return $setting->toArray();
			},
			$settings
		);
	}
}