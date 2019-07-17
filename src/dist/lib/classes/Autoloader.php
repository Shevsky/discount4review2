<?php

namespace Discount4Review;

class Autoloader
{
	private static $namespace = 'Discount4Review';
	private static $registered;

	/**
	 * @param bool $prepend
	 */
	public static function register($prepend = false)
	{
		if (self::$registered === true)
		{
			return;
		}

		spl_autoload_register(
			[__CLASS__, 'autoload'],
			true,
			$prepend
		);
		self::$registered = true;
	}

	/**
	 * @param string $full_classname
	 */
	private static function autoload($full_classname)
	{
		$classname_parts = explode('\\', $full_classname);
		if (count($classname_parts) < 2)
		{
			return;
		}

		$root_namespace = array_shift($classname_parts);
		$classname = array_pop($classname_parts);
		if ($root_namespace === self::$namespace)
		{
			$path_parts = [__DIR__];
			$path_parts = array_merge($path_parts, array_map('strtolower', $classname_parts));
			$path_parts[] = "{$classname}.php";

			$path = implode('/', $path_parts);

			if (file_exists($path))
			{
				require_once $path;
			}
			else
			{
				echo "File not found: {$path}";
			}
		}
	}
}