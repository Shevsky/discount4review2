<?php

namespace Shevsky\Discount4Review\Domain\Wa\Product;

use Exception;
use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Domain\Wa\Factory;
use Shevsky\Discount4Review\Persistence\Access\ICurrency;
use Shevsky\Discount4Review\Persistence\Product\IProduct;
use Shevsky\Discount4Review\Persistence\Product\ISku;
use Shevsky\Discount4Review\Persistence\Review\IReview;
use shopProduct;

class Product implements IProduct
{
	private $id;
	private $product;
	private $skus;

	/**
	 * @param mixed $data
	 * @throws Exception
	 */
	public function __construct($data)
	{
		if (!is_numeric($data))
		{
			if ($data instanceof shopProduct)
			{
				$this->id = $data->getId();
				$this->product = $data;
			}
			elseif (is_array($data) && array_key_exists('id', $data))
			{
				$this->id = $data['id'];
				$this->product = new shopProduct($data);
			}
			else
			{
				throw new Exception('Неизвестные аргументы для построения экземпляра товара');
			}
		}
		else
		{
			$this->id = $data;
			$this->product = new shopProduct($this->id);
		}
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return (int)$this->id;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->product->name;
	}

	/**
	 * @return ISku
	 */
	public function getSku()
	{
		$_sku = $this->product->skus[$this->product->sku_id];

		$sku = Factory::getInstance()->createSku($this, $_sku);

		return $sku;
	}

	/**
	 * @return ISku[]
	 */
	public function getAllSkus()
	{
		return array_values(
			array_map(
				[__CLASS__, 'buildSku'],
				$this->product->skus
			)
		);
	}

	/**
	 * @return IReview[]
	 */
	public function getReviews()
	{
		return [];
	}

	/**
	 * @return ICurrency
	 */
	public function getCurrency()
	{
		return Context::getInstance()->getCurrencyRegistry()->getByCode($this->product->currency);
	}

	/**
	 * @param $sku
	 * @return Sku
	 */
	private function buildSku($sku)
	{
		return Factory::getInstance()->createSku($this, $sku);
	}
}