<?php

namespace Shevsky\Discount4Review\Persistence\Settings;

interface ISettingsStorage
{
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
	 * @return array[] = [
	 *  $name => [
	 *      '*' => mixed,
	 *      $id => mixed
	 *  ]
	 * ]
	 */
	public function toArray();
}