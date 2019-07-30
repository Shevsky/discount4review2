<?php

namespace Shevsky\Discount4Review\Domain\Wa;

use Exception;
use Shevsky\Discount4Review\Domain\Wa\Review\Review;
use Shevsky\Discount4Review\Persistence\IFactory;
use Shevsky\Discount4Review\Domain\Wa\Product\Product;
use Shevsky\Discount4Review\Domain\Wa\Product\Sku;
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
}