<?php

namespace Shevsky\Discount4Review\Domain\Wa\Product;

use Exception;
use Shevsky\Discount4Review\Persistence\Access\ICurrency;
use Shevsky\Discount4Review\Persistence\Product\ISku;
use shopProductSkusModel;

class Sku implements ISku
{
	private $product;
	private $id;
	private $sku;
	private $product_skus_model;

	/**
	 * @param Product $product
	 * @param mixed $data
	 * @throws Exception
	 */
	public function __construct(Product $product, $data)
	{
		$this->product_skus_model = new shopProductSkusModel();
		$this->product = $product;

		if (is_array($data) && array_key_exists('id', $data))
		{
			$this->id = (int)$data['id'];
			$this->sku = $data;
		}
		elseif (is_numeric($data))
		{
			$this->id = (int)$data;
			$this->sku = $this->product_skus_model->getSku($this->id);
		}
		else
		{
			throw new Exception('Неизвестные аргументы для построения экземпляра артикула');
		}
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
	 * @return ICurrency
	 */
	public function getCurrency()
	{
		return $this->product->getCurrency();
	}
}