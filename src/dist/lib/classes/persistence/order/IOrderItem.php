<?php

namespace Shevsky\Discount4Review\Persistence\Order;

use Shevsky\Discount4Review\Persistence\Product\IProduct;
use Shevsky\Discount4Review\Persistence\Product\ISku;

interface IOrderItem
{
	/**
	 * @return int
	 */
	public function getId();

	/**
	 * @return IProduct
	 */
	public function getProduct();

	/**
	 * @return ISku
	 */
	public function getSku();
}