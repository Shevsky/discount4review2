<?php

use Discount4Review\Autoloader;
use Discount4Review\Context\Context;

class shopDiscount4reviewPlugin extends shopPlugin
{
	const APP_ID = 'shop';
	const PLUGIN_ID = 'discount4review';

	private static $self;

	/**
	 * @inheritDoc
	 */
	public function __construct($info)
	{
		parent::__construct($info);

		self::registerAutoloader();
		self::$self = $this;
	}

	/**
	 * @return self
	 */
	public static function getInstance()
	{
		if (!isset(self::$self))
		{
			self::$self = wa(self::APP_ID)->getPlugin(self::PLUGIN_ID);
		}

		return self::$self;
	}

	/**
	 * @return Context
	 */
	public static function getContext()
	{
		self::registerAutoloader();

		return Context::getInstance(self::getInstance());
	}

	private static function registerAutoloader()
	{
		require_once __DIR__ . '/classes/Autoloader.php';

		Autoloader::register();
	}
}