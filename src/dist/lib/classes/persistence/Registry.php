<?php

namespace Discount4Review\Persistence;

class Registry
{
	private $factory;

	private $products = [];

	/**
	 * @param IFactory $factory
	 */
	public function __construct(IFactory $factory)
	{
		$this->factory = $factory;
	}

	/**
	 * @param mixed $identify_key
	 * @return Product\IProduct
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