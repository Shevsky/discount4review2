<?php

namespace Shevsky\Discount4Review\Persistence\Product;

use Shevsky\Discount4Review\Persistence\Access\ICurrency;
use Shevsky\Discount4Review\Persistence\Review\IReview;

interface IProduct
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
	 * @return ISku
	 */
	public function getSku();

	/**
	 * @return ISku[]
	 */
	public function getAllSkus();

	/**
	 * @return IReview[]
	 */
	public function getReviews();

	/**
	 * @return ICurrency
	 */
	public function getCurrency();
}