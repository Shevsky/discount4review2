<?php

namespace Shevsky\Discount4Review\Context;

/**
 * @mixin Context
 */
trait RouterAccess
{
	/**
	 * @return string
	 */
	public static function getPluginPath()
	{
		return self::getInstance()->getRoutingUtil()->getPluginPath();
	}

	/**
	 * @param bool $absolute
	 * @return string
	 */
	public static function getPluginUrl($absolute = true)
	{
		return self::getInstance()->getRoutingUtil()->getPluginUrl($absolute);
	}

	/**
	 * @param string $path
	 * @param bool $absolute
	 * @return string
	 */
	public static function getControllerUrl($path, $absolute = true)
	{
		return self::getInstance()->getRoutingUtil()->getControllerUrl($path, $absolute);
	}

	/**
	 * @return string
	 */
	public static function getCasePath()
	{
		return self::getInstance()->getRoutingUtil()->getCasePath();
	}

	/**
	 * @param bool $public
	 * @return string
	 */
	public static function getDataPath($public = true)
	{
		return self::getInstance()->getRoutingUtil()->getDataPath($public);
	}

	/**
	 * @param bool $public
	 * @return string
	 */
	public static function getDataUrl($public = true)
	{
		return self::getInstance()->getRoutingUtil()->getDataUrl($public);
	}
}