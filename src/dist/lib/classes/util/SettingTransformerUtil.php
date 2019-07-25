<?php

namespace Shevsky\Discount4Review\Util;

class SettingTransformerUtil
{
	/**
	 * @param mixed $value
	 * @param string $type
	 * @return mixed
	 */
	public static function transform($value, $type)
	{
		if ($type === 'string')
		{
			return self::transformString($value);
		}
		elseif ($type === 'array')
		{
			return self::transformArray($value);
		}
		elseif ($type === 'boolean')
		{
			return self::transformBool($value);
		}
		elseif ($type === 'integer')
		{
			return self::transformInt($value);
		}

		return $value;
	}

	/**
	 * @param mixed $value
	 * @return string
	 */
	private static function transformString($value)
	{
		return (string)$value;
	}

	/**
	 * @param mixed $value
	 * @return array
	 */
	private static function transformArray($value)
	{
		if (is_array($value))
		{
			return $value;
		}
		elseif (is_string($value))
		{
			$value_json_decoded = json_decode($value, true);
			if ($value_json_decoded === null || json_last_error() !== JSON_ERROR_NONE)
			{
				return [];
			}

			return $value_json_decoded;
		}

		return [];
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	private static function transformBool($value)
	{
		if ($value == '1')
		{
			return true;
		}

		return false;
	}

	/**
	 * @param mixed $value
	 * @return int
	 */
	private static function transformInt($value)
	{
		return (int)$value;
	}
}