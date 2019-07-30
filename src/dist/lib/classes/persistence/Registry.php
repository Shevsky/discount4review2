<?php

namespace Shevsky\Discount4Review\Persistence;

use Shevsky\Discount4Review\Persistence\Product\IProduct;
use Shevsky\Discount4Review\Persistence\Product\ISku;

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
	 * @return IProduct
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
	 * @param int $id
	 * @param IProduct $product
	 */
	public function setProduct($id, IProduct $product)
	{
		$this->products[$id] = $product;
	}

	/**
	 * @param IProduct $product
	 * @param int $id
	 * @return ISku
	 */
	public function getSku(IProduct $product, $id)
	{
		$identify_key = "{$product->getId()}/{$id}";

		if (!isset($this->skus[$identify_key]))
		{
			$this->skus[$identify_key] = $this->factory->createSku($product, $id);
		}

		return $this->skus[$identify_key];
	}

	/**
	 * @param IProduct $product
	 * @param int $id
	 * @param ISku $sku
	 */
	public function setSku(IProduct $product, $id, ISku $sku)
	{
		$identify_key = "{$product->getId()}/{$id}";

		$this->skus[$identify_key] = $sku;
	}
}