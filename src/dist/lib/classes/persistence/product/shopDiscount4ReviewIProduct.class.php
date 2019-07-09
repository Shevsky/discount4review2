<?php

interface shopDiscount4ReviewIProduct
{
	/**
	 * @return int
	 */
	public function getId();

	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return shopDiscount4ReviewIProductSku
	 */
	public function getSku();

	/**
	 * @return shopDiscount4ReviewIProductSku[]
	 */
	public function getAllSkus();

	/**
	 * @return shopDiscount4ReviewIReview[]
	 */
	public function getReviews();
}