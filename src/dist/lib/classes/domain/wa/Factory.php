<?php

namespace Shevsky\Discount4Review\Domain\Wa;

use Exception;
use Shevsky\Discount4Review\Domain\Wa\Order\Order;
use Shevsky\Discount4Review\Domain\Wa\Order\OrderItem;
use Shevsky\Discount4Review\Domain\Wa\Review\Review;
use Shevsky\Discount4Review\Persistence\IFactory;
use Shevsky\Discount4Review\Domain\Wa\Product\Product;
use Shevsky\Discount4Review\Domain\Wa\Product\Sku;
use Shevsky\Discount4Review\Persistence\Order\IOrder;
use Shevsky\Discount4Review\Persistence\Order\IOrderItem;
use Shevsky\Discount4Review\Persistence\Product\IProduct;
use Shevsky\Discount4Review\Persistence\Review\IReview;

class Factory implements IFactory
{
	private static $self;

	private function __construct()
	{
	}

	/**
	 * @return self
	 */
	public static function getInstance()
	{
		if (!isset(self::$self))
		{
			self::$self = new self();
		}

		return self::$self;
	}

	/**
	 * @param mixed $data
	 * @return Product
	 * @throws Exception
	 */
	public function createProduct($data)
	{
		return new Product($data);
	}

	/**
	 * @param IProduct $product
	 * @param mixed $data
	 * @return Sku
	 * @throws Exception
	 */
	public function createSku(IProduct $product, $data)
	{
		/**
		 * @var Product $product
		 */
		return new Sku($product, $data);
	}

	/**
	 * @param mixed $data
	 * @return IReview
	 * @throws Exception
	 */
	public function createReview($data)
	{
		return new Review($data);
	}

	/**
	 * @param mixed $data
	 * @return IOrder
	 * @throws Exception
	 */
	public function createOrder($data)
	{
		return new Order($data);
	}

	/**
	 * @param mixed $data
	 * @return IOrderItem
	 * @throws Exception
	 */
	public function createOrderItem($data)
	{
		return new OrderItem($data);
	}
}