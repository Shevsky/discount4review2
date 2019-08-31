<?php

namespace Shevsky\Discount4Review\Util;

class SettingRetransformerUtil
{
	/**
	 * @param mixed $value
	 * @param string $type
	 * @return string
	 */
	public static function retransform($value, $type)
	{
		if ($type === 'string')
		{
			return self::retransformString($value);
		}
		elseif ($type === 'array')
		{
			return self::retransformArray($value);
		}
		elseif ($type === 'object')
		{
			return self::retransformObject($value);
		}
		elseif ($type === 'boolean')
		{
			return self::retransformBool($value);
		}
		elseif ($type === 'integer')
		{
			return self::retransformInt($value);
		}

		return $value;
	}

	/**
	 * @param mixed $value
	 * @return string
	 */
	private static function retransformString($value)
	{
		return (string)$value;
	}

	/**
	 * @param mixed $value
	 * @return string
	 */
	private static function retransformArray($value)
	{
		if (is_array($value))
		{
			return json_encode($value);
		}

		return '[]';
	}

	/**
	 * @param mixed $value
	 * @return string
	 */
	private static function retransformObject($value)
	{
		if (is_array($value))
		{
			return json_encode($value);
		}

		return '{}';
	}

	/**
	 * @param mixed $value
	 * @return string
	 */
	private static function retransformBool($value)
	{
		if ($value === true)
		{
			return '1';
		}

		return '0';
	}

	/**
	 * @param mixed $value
	 * @return string
	 */
	private static function retransformInt($value)
	{
		if (!is_numeric($value))
		{
			return '0';
		}

		return (string)$value;
	}
}