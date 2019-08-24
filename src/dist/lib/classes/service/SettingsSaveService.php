<?php

namespace Shevsky\Discount4Review\Service;

use Shevsky\Discount4Review\Domain\Common\SettingsItem\SettingsItem;
use Shevsky\Discount4Review\Persistence\Settings\ISettingsStorage;

class SettingsSaveService
{
	private $settings_storage;
	private $settings;
	private $is_saved = false;

	/**
	 * SettingsSaveService constructor.
	 * @param ISettingsStorage $settings_storage
	 * @param mixed[] $settings = [
	 *  $name => [
	 *      '*' => mixed,
	 *      $id => mixed
	 *  ]
	 * ]
	 */
	public function __construct(ISettingsStorage $settings_storage, array $settings)
	{
		$this->settings_storage = $settings_storage;
		$this->settings = $settings;
	}

	public function saveSettings()
	{
		if ($this->is_saved)
		{
			return;
		}

		foreach ($this->settings as $name => $values)
		{
			$this->saveSetting($name, $values);
		}

		$this->is_saved = true;
	}

	/**
	 * @param string $name
	 * @param mixed[] $values
	 */
	private function saveSetting($name, $values)
	{
		$setting_config = $this->settings_storage->getSettingConfig($name);

		$setting = new SettingsItem($name, $values, $setting_config->getType());

		$this->settings_storage->setSetting($name, $setting);
	}
}