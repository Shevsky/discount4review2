<?php

namespace Discount4Review\Domain;

use Discount4Review\Domain\Product\Product;
use Discount4Review\Persistence\IFactory;

class Factory implements IFactory
{
	/**
	 * @param string $identify_key
	 * @return Product
	 */
	public function createProduct($identify_key)
	{
		return new Product($identify_key);
	}
}