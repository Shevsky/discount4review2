<?php

class shopDiscount4ReviewFactory implements shopDiscount4ReviewIFactory
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