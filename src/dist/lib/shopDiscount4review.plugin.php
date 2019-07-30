<?php

use Shevsky\Discount4Review\Autoloader;
use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Domain\Wa\Factory;
use Shevsky\Discount4Review\Domain\Wa\Handler\MyOrderHandler;
use Shevsky\Discount4Review\Domain\Wa\Handler\ReviewAddBeforeHandler;
use Shevsky\Discount4Review\Domain\Wa\Handler\ReviewsPageHandler;
use Shevsky\Discount4Review\Domain\Wa\Product\Product;

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
		try
		{
			return MyOrderHandler::dispatch($order);
		}
		catch (Exception $e)
		{
			return '';
		}
	}

	/**
	 * @param mixed $product
	 * @return array
	 */
	public function frontendProductHandler($product)
	{
		try
		{
			ReviewsPageHandler::dispatch(Factory::getInstance()->createProduct($product));
		}
		catch (Exception $e)
		{
		}

		return [];
	}

	/**
	 * @param array $params
	 */
	public function frontendReviewAddBeforeHandler($params)
	{
		if (!is_array($params) || !array_key_exists('data', $params) || !array_key_exists('product', $params))
		{
			return;
		}

		try
		{
			ReviewAddBeforeHandler::dispatch(
				Factory::getInstance()->createProduct($params['product']),
				Factory::getInstance()->createReview($params['data'])
			);
		}
		catch (Exception $e)
		{
		}
	}

	private static function registerAutoloader()
	{
		require_once __DIR__ . '/classes/Autoloader.php';

		Autoloader::register();
	}
}