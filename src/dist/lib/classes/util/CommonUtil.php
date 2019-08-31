<?php

namespace Shevsky\Discount4Review\Util;

class CommonUtil
{
	/**
	 * @param array $array
	 * @return bool
	 */
	public static function isAssocArray(array $array)
	{
		if ([] !== $array)
		{
			return true;
		}

		return array_keys($array) !== range(0, count($array) - 1);
	}

	/**
	 * @param array $array
	 * @return bool
	 */
	public static function isNumericArray(array $array)
	{
		return !self::isAssocArray($array);
	}
}