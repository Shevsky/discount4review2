<?php

namespace Shevsky\Discount4Review\Persistence\Settings;

use Shevsky\Discount4Review\Persistence\Access\ISettingsAccess;

interface ISettingsStorage
{
	/**
	 * @return ISettingsAccess
	 */
	public function getAccess();

	/**
	 * @return ISettingsItem[] = [
	 *  $name => ISettingsItem
	 * ]
	 */
	public function getSettings();

	/**
	 * @param string $name
	 * @return ISettingsItem
	 */
	public function getSetting($name);

	/**
	 * @param string $name
	 * @param ISettingsItem $setting
	 */
	public function setSetting($name, ISettingsItem $setting);

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasSetting($name);

	/**
	 * @param string $name
	 * @return ISettingsConfigItem
	 */
	public function getSettingConfig($name);

	/**
	 * @return array[] = [
	 *  $name => [
	 *      '*' => mixed,
	 *      $id => mixed
	 *  ]
	 * ]
	 */
	public function toArray();
}