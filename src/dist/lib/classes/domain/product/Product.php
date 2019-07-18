<?php

namespace Discount4Review\Domain\Product;

use Discount4Review\Context;
use Discount4Review\Persistence\Product\IProduct;
use Discount4Review\Persistence\Product\ISku;
use Discount4Review\Persistence\Review\IReview;
use shopProduct;

class Product implements IProduct
{
	private $id;
	private $product;
	private $skus;

	/**
	 * @param int $id
	 */
	public function __construct($id)
	{
		$this->id = $id;
		$this->product = new shopProduct($this->id);
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

		/**
		 * @var Sku $sku
		 */
		$sku = Context::getInstance()->getRegistry()->getSku($this, $_sku['id']);
		$sku->setSku($_sku);

		return $sku;
	}

	/**
	 * @return ISku[]
	 */
	public function getAllSkus()
	{
		return array_values(
			array_map(
				function($_sku) {
					/**
					 * @var Sku $sku
					 */
					$sku = Context::getInstance()->getRegistry()->getSku($this, $_sku['id']);
					$sku->setSku($_sku);

					return $sku;
				},
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
	 * @return string
	 */
	public function getCurrency()
	{
		return $this->product->currency;
	}
}