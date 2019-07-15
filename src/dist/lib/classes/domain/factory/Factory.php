<?php

namespace Discount4Review;

class Factory implements IFactory
{
	/**
	 * @param string $identify_key
	 * @return shopDiscount4ReviewIProduct
	 */
	public function createProduct($identify_key)
	{
		return new shopDiscount4ReviewProduct($identify_key);
	}
}