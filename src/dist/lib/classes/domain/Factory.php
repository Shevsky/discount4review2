<?php

namespace Discount4Review\Domain;

use Discount4Review\Persistence\IFactory;
use Discount4Review\Domain\Product\Product;
use Discount4Review\Domain\Product\Sku;
use Discount4Review\Persistence\Product\IProduct;

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