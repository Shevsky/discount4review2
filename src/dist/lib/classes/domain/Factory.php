<?php

namespace Shevsky\Discount4Review\Domain;

use Shevsky\Discount4Review\Persistence\IFactory;
use Shevsky\Discount4Review\Domain\Product\Product;
use Shevsky\Discount4Review\Domain\Product\Sku;
use Shevsky\Discount4Review\Persistence\Product\IProduct;

class Factory implements IFactory
{
	/**
	 * @param int $id
	 * @return Product
	 */
	public function createProduct($id)
	{
		return new Product($id);
	}

	/**
	 * @param IProduct $product
	 * @param int $id
	 * @return Sku
	 */
	public function createSku(IProduct $product, $id)
	{
		/**
		 * @var Product $product
		 */
		return new Sku($product, $id);
	}
}