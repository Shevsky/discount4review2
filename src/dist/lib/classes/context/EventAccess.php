<?php

namespace Shevsky\Discount4Review\Context;

/**
 * @mixin Context
 */
trait EventAccess
{
	/**
	 * @param string $name
	 * @param mixed $params
	 * @return mixed
	 */
	public static function dispatchEvent($name, &$params = null)
	{
		return self::getInstance()->getEventUtil()->dispatch($name, $params);
	}

	/**
	 * @param string $name
	 * @param mixed $params
	 * @return mixed
	 */
	public static function dispatchSystemEvent($name, &$params = null)
	{
		return self::getInstance()->getEventUtil()->dispatchSystem($name, $params);
	}
}