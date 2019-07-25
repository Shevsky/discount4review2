<?php

namespace Shevsky\Discount4Review\Persistence;

class Registry
{
	private $factory;

	private $products = [];
	private $skus = [];

	/**
	 * @param IFactory $factory
	 */
	public function __construct(IFactory $factory)
	{
		$this->factory = $factory;
	}

	/**
	 * @param int $id
	 * @return Product\IProduct
	 */
	public function getProduct($id)
	{
		if (!isset($this->products[$id]))
		{
			$this->products[$id] = $this->factory->createProduct($id);
		}

		return $this->products[$id];
	}

	/**
	 * @param Product\IProduct $product
	 * @param int $id
	 * @return Product\ISku
	 */
	public function getSku(Product\IProduct $product, $id)
	{
		$identify_key = "{$product->getId()}/{$id}";

		if (!isset($this->skus[$identify_key]))
		{
			$this->skus[$identify_key] = $this->factory->createSku($product, $id);
		}

		return $this->skus[$identify_key];
	}
}