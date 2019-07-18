<?php

namespace Discount4Review\Persistence;

interface IFactory
{
	/**
	 * @param int $id
	 * @return Product\IProduct
	 */
	public function createProduct($id);

	/**
	 * @param Product\IProduct $product
	 * @param int $id
	 * @return Product\ISku
	 */
	public function createSku(Product\IProduct $product, $id);
}