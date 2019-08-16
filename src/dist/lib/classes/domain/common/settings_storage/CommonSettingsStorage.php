<?php

namespace Shevsky\Discount4Review\Domain\Common\SettingsStorage;

use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Domain\Common\SettingsConfig\SettingsConfig;
use Shevsky\Discount4Review\Domain\Common\SettingsItem\SettingsItem;
use Shevsky\Discount4Review\Persistence\Access\ISettingsAccess;
use Shevsky\Discount4Review\Persistence\Settings\ISettingsItem;
use Shevsky\Discount4Review\Persistence\Settings\ISettingsStorage;
use Shevsky\Discount4Review\Service\SettingsService;
use Shevsky\Discount4Review\Util\SettingRetransformerUtil;
use Exception;

abstract class CommonSettingsStorage implements ISettingsStorage
{
	protected $access;

	private $setting_items = [];
	private $settings_config;
	private $settings_service;

	/**
	 * @param ISettingsAccess $access
	 */
	public function __construct(ISettingsAccess $access)
	{
		$this->access = $access;
		$this->settings_config = new SettingsConfig($this->getConfigPath());
	}

	/**
	 * @return SettingsService
	 * @throws Exception
	 */
	public function getSettingsService()
	{
		if (!isset($this->settings_service))
		{
			throw new Exception('Сервис настроек не определен');
		}

		return $this->settings_service;
	}

	/**
	 * @param SettingsService $settings_service
	 */
	public function setSettingsService(SettingsService $settings_service)
	{
		$this->settings_service = $settings_service;
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
			if (!is_array($values))
			{
				$values = [];
			}
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
	 * @param string $name
	 * @return string
	 */
	public function readSetting($name)
	{
		return $this->getSetting($name)->getGeneral();
	}

	/**
	 * @param string $name
	 * @return mixed
	 */
	public function readSettingForTheme($name)
	{
		return $this->getSettingsService()->readForTheme($this->getSetting($name));
	}

	/**
	 * @param string $name
	 * @return mixed
	 */
	public function readSettingForStorefront($name)
	{
		return $this->getSettingsService()->readForStorefront($this->getSetting($name));
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
			[__CLASS__, 'settingsItemToArray'],
			$settings
		);
	}

	/**
	 * @param ISettingsItem $settings_item
	 * @return mixed[]
	 */
	private function settingsItemToArray(ISettingsItem $settings_item)
	{
		return $settings_item->toArray();
	}
}