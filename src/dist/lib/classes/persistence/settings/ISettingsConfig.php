<?php

namespace BodySite\SearchPro\Persistence\Settings;

interface ISettingsConfig
{
	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasSetting($name);

	/**
	 * @param string $name
	 * @return ISettingsConfigItem
	 */
	public function getSetting($name);

	/**
	 * @return ISettingsConfigIterator
	 */
	public function getIterator();
}