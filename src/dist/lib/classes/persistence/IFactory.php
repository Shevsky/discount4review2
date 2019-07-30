<?php

namespace Shevsky\Discount4Review\Persistence;

interface IFactory
{
	/**
	 * @param mixed $data
	 * @return Product\IProduct
	 */
	public function createProduct($data);

	/**
	 * @param Product\IProduct $product
	 * @param mixed $data
	 * @return Product\ISku
	 */
	public function createSku(Product\IProduct $product, $data);
}