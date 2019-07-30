<?php

namespace Shevsky\Discount4Review\Persistence;

use Shevsky\Discount4Review\Persistence\Product\IProduct;
use Shevsky\Discount4Review\Persistence\Product\ISku;
use Shevsky\Discount4Review\Persistence\Review\IReview;

interface IFactory
{
	/**
	 * @param mixed $data
	 * @return IProduct
	 */
	public function createProduct($data);

	/**
	 * @param Product\IProduct $product
	 * @param mixed $data
	 * @return ISku
	 */
	public function createSku(Product\IProduct $product, $data);

	/**
	 * @param mixed $data
	 * @return IReview
	 */
	public function createReview($data);
}