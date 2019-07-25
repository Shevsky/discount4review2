<?php

namespace Shevsky\Discount4Review\Domain\Wa\Product;

use Shevsky\Discount4Review\Persistence\Product\ISku;

class Sku implements ISku
{
	private $product;
	private $id;
	private $sku;

	/**
	 * @param Product $product
	 * @param int $id
	 */
	public function __construct(Product $product, $id)
	{
		$this->product = $product;
		$this->id = $id;
	}

	/**
	 * @param mixed[] $sku = [
	 *  'name' => string,
	 *  'sku' => string,
	 *  'count' => int
	 * ]
	 */
	public function setSku(array $sku = [])
	{
		$this->sku = $sku;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getCode()
	{
		if (isset($this->sku['sku']))
		{
			return $this->sku['sku'];
		}

		return '';
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		if (isset($this->sku['name']))
		{
			return $this->sku['name'];
		}

		return '';
	}

	/**
	 * @return string
	 */
	public function getCurrency()
	{
		return $this->product->getCurrency();
	}
}