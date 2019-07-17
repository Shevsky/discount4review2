<?php

namespace Discount4Review\Domain\Product;

use Discount4Review\Persistence\Product\IProduct;
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
	 * @return shopDiscount4ReviewIReview[]
	 */
	public function getReviews()
	{
		return [];
	}
}