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
	 * @param mixed $data
	 */
	public function __construct(Product $product, $data)
	{
		$this->product = $product;
		$this->id = (int)$data['id'];
		$this->sku = $data;
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