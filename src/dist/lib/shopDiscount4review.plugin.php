<?php

use Shevsky\Discount4Review\Autoloader;
use Shevsky\Discount4Review\Context\Context;

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
	 * @return bool
	 */
	public static function isEnabled()
	{
		$context = self::getContext();

		return $context::getPluginStatus();
	}

	/**
	 * @return Context
	 */
	public static function getContext()
	{
		self::registerAutoloader();

		return Context::getInstance(self::getInstance());
	}

	/**
	 * @param mixed $order
	 * @return string
	 */
	public function frontendMyOrderHandler($order)
	{
		if (!self::isEnabled())
		{
			return '';
		}

		try
		{
			return self::getContext()->getFrontendService()->renderMyOrder([]);
		}
		catch (Exception $e)
		{
			return '';
		}
	}

	private static function registerAutoloader()
	{
		require_once __DIR__ . '/classes/Autoloader.php';

		Autoloader::register();
	}
}