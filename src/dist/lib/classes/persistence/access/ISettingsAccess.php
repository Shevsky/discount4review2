<?php

namespace Shevsky\Discount4Review\Persistence\Access;

interface ISettingsAccess
{
	/**
	 * @param string $name
	 * @return string[] = [
	 *  $id => string
	 * ]
	 */
	public function readSetting($name);

	/**
	 * @param string $name
	 * @param string[] $value = [
	 *  $id => string
	 * ]
	 */
	public function writeSetting($name, $value);

	/**
	 * @param string $name
	 * @param string[] $ids
	 */
	public function deleteSetting($name, array $ids = []);

	public function resetSettings();
}