<?php

namespace Shevsky\Discount4Review\Persistence\Review;

use DateTime;
use Shevsky\Discount4Review\Persistence\Order\IOrderItem;
use Shevsky\Discount4Review\Persistence\Product\IProduct;
use Shevsky\Discount4Review\Persistence\Product\ISku;

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
	 * @return ISku|null
	 */
	public function getSku();

	/**
	 * @return IOrderItem|null
	 */
	public function getOrderItem();

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