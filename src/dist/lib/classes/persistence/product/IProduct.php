<?php

namespace Discount4Review\Product;

use Discount4Review\Review\IReview;

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
}