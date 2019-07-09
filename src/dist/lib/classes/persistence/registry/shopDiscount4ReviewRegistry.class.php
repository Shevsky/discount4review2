<?php

class shopDiscount4ReviewRegistry
{
	private $factory;

	private $products = [];

	/**
	 * @param shopDiscount4ReviewIFactory $factory
	 */
	public function __construct(shopDiscount4ReviewIFactory $factory)
	{
		$this->factory = $factory;
	}

	/**
	 * @param mixed $identify_key
	 * @return shopDiscount4ReviewIProduct
	 */
	public function getProduct($identify_key)
	{
		if (!isset($this->products[$identify_key]))
		{
			$this->products[$identify_key] = $this->factory->createProduct($identify_key);
		}

		return $this->products[$identify_key];
	}
}