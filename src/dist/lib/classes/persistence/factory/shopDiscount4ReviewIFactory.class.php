<?php

interface shopDiscount4ReviewIFactory
{
	/**
	 * @param mixed $identify_key
	 * @return shopDiscount4ReviewIProduct
	 */
	public function createProduct($identify_key);
}