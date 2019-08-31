<?php

namespace Shevsky\Discount4Review\Util;

use Exception;
use stdClass;

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
		elseif ($type === 'object')
		{
			return self::transformObject($value);
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
			try
			{
				$value = JsonUtil::decode($value);
				if (!is_array($value) || CommonUtil::isAssocArray($value))
				{
					$value = [];
				}
			}
			catch (Exception $e)
			{
				return [];
			}

			return $value;
		}

		return [];
	}

	private static function transformObject($value)
	{
		if (is_object($value))
		{
			return $value;
		}
		elseif (is_string($value))
		{
			try
			{
				$value = JsonUtil::decode($value);

				if (!is_object($value) && is_array($value)
					&& CommonUtil::isNumericArray(
						$value
					))
				{
					$value = (object)$value;
				}
			}
			catch (Exception $e)
			{
				return new stdClass();
			}

			return $value;
		}

		return new stdClass();
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