<?php

namespace Shevsky\Discount4Review\Util;

use Exception;
use SimpleXMLElement;

class IncludeUtil
{
	/**
	 * @param string $path
	 * @param string $method
	 * @param string $type
	 * @param mixed $default
	 * @return mixed
	 */
	private function includeFile($path, $method, $type, $default)
	{
		$result = $default;

		if (file_exists($path))
		{
			if ($method === 'include')
			{
				$result = include($path);
			}
			elseif ($method === 'file_get_contents')
			{
				$result = file_get_contents($path);
			}
			elseif ($method === 'simplexml_load_file')
			{
				$result = simplexml_load_file($path);
			}

			if ($type !== null)
			{
				if (substr($type, 0, strlen('instance:')) === 'instance:')
				{
					$type_instance = substr($type, strlen('instance:'));
					$is_bad_type = !is_a($result, $type_instance);
				}
				else
				{
					$is_bad_type = gettype($result) !== $type;
				}

				if ($is_bad_type)
				{
					$result = $default;
				}
			}

			if ($type !== null && !gettype($result) === $type)
			{
				$result = $default;
			}
		}

		return $result;
	}

	/**
	 * @param string $path
	 * @return array
	 */
	public function includePHPFile($path)
	{
		return $this->includeFile($path, 'include', 'array', []);
	}

	/**
	 * @param string $path
	 * @return array
	 */
	public function includeTextFile($path)
	{
		return $this->includeFile($path, 'file_get_contents', 'string', '');
	}

	/**
	 * @param string $path
	 * @return SimpleXMLElement
	 * @throws Exception
	 */
	public function includeXMLFile($path)
	{
		$config = $this->includeFile($path, 'simplexml_load_file', 'instance:SimpleXMLElement', null);

		if ($config === null || !$config instanceof SimpleXMLElement)
		{
			throw new Exception("Конфигурация XML-файла \"{$path}\" представлена некорректно");
		}

		return $config;
	}
}