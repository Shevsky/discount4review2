<?php

namespace Shevsky\Discount4Review\Persistence\Product;

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
	 * @return string
	 */
	public function getCurrency();
}