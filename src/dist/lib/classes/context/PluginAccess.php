<?php

namespace Shevsky\Discount4Review\Context;

use shopDiscount4reviewPlugin;

/**
 * @mixin Context
 */
trait PluginAccess
{
	/**
	 * @return bool
	 */
	public static function getPluginStatus()
	{
		return self::getInstance()->getBasicSettingsStorage()->getStatus();
	}

	/**
	 * @return string
	 */
	public static function getPluginVersion()
	{
		return shopDiscount4reviewPlugin::getInstance()->getVersion();
	}
}