<?php

interface shopDiscount4ReviewIReview
{
	/**
	 * @return int
	 */
	public function getId();

	/**
	 * @return shopDiscount4ReviewIProduct
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
	 * @return shopDiscount4ReviewIReviewAuthor
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
	 * @return shopDiscount4ReviewIReviewImage[]
	 */
	public function getImages();
}