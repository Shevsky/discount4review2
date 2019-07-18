<?php

namespace Discount4Review\Domain\Product;

use Discount4Review\Persistence\Product\IProduct;
use Discount4Review\Persistence\Product\ISku;
use Discount4Review\Persistence\Review\IReview;
use shopProduct;

class Product implements IProduct
{
	private $id;
	private $product;

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
		return null;
	}

	/**
	 * @return ISku[]
	 */
	public function getAllSkus()
	{
		return [];
	}

	/**
	 * @return IReview[]
	 */
	public function getReviews()
	{
		return [];
	}
}