<?php

namespace Discount4Review\Persistence;

interface IFactory
{
	/**
	 * @param mixed $identify_key
	 * @return Product\IProduct
	 */
	public function createProduct($identify_key);
}