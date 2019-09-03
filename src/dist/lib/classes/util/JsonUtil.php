<?php

namespace Shevsky\Discount4Review\Util;

use Exception;

class JsonUtil
{
	/**
	 * @param mixed $value
	 * @return string
	 * @throws Exception
	 */
	public static function encode($value)
	{
		$encoded_value = json_encode($value);

		if (is_string($encoded_value))
		{
			return $encoded_value;
		}

		throw new Exception("Не удалось кодировать значение в JSON-представление");
	}

	/**
	 * @param string $json
	 * @return array
	 * @throws Exception
	 */
	public static function decode($json)
	{
		$decoded_value = json_decode($json, true);

		if ($decoded_value === null || json_last_error() !== JSON_ERROR_NONE)
		{
			throw new Exception("Не удалось раскодировать как JSON-строку: " . json_last_error_msg());
		}

		return $decoded_value;
	}
}