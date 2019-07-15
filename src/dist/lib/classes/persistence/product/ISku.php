<?php

namespace Discount4Review\Product;

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
}