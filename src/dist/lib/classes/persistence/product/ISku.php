<?php

namespace Shevsky\Discount4Review\Persistence\Product;

use Shevsky\Discount4Review\Persistence\Access\ICurrency;

interface ISku
{
	/**
	 * @return int
	 */
	public function getId();

	/**
	 * @return string
	 */
	public function getCode();

	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return ICurrency
	 */
	public function getCurrency();
}