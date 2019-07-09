<?php

class shopDiscount4ReviewProduct implements shopDiscount4ReviewIProduct
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
	 * @return shopDiscount4ReviewIProductSku
	 */
	public function getSku()
	{
		// TODO: Implement getSku() method.
		throw new Exception('[getSku] not implemented');
	}

	/**
	 * @return shopDiscount4ReviewIProductSku[]
	 */
	public function getAllSkus()
	{
		// TODO: Implement getAllSkus() method.
		throw new Exception('[getAllSkus] not implemented');
	}

	/**
	 * @return shopDiscount4ReviewIReview[]
	 */
	public function getReviews()
	{
		// TODO: Implement getReviews() method.
		throw new Exception('[getReviews] not implemented');
	}
}