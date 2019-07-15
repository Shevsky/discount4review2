<?php

namespace Discount4Review\Review;

use DateTime;
use Discount4Review\Product\IProduct;

interface IReview
{
	/**
	 * @return int
	 */
	public function getId();

	/**
	 * @return IProduct
	 */
	public function getProduct();

	/**
	 * Возвращает источник - откуда был добавлен отзыв
	 * @return string[order]
	 * @return string[product]
	 */
	public function getOrigin();

	/**
	 * @return float
	 */
	public function getRate();

	/**
	 * @return IAuthor
	 */
	public function getAuthor();

	/**
	 * @return DateTime
	 */
	public function getDateTime();

	/**
	 * @return string
	 */
	public function getTitle();

	/**
	 * @return string
	 */
	public function getText();

	/**
	 * @return IImage[]
	 */
	public function getImages();
}