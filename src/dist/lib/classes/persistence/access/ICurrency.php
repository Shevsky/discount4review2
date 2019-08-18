<?php

namespace Shevsky\Discount4Review\Persistence\Access;

interface ICurrency
{
	/**
	 * @return string
	 */
	public function getCode();

	/**
	 * @return string
	 */
	public function getSign();

	/**
	 * @return string
	 */
	public function getSignHtml();

	/**
	 * @return int
	 */
	public function getSignPosition();

	/**
	 * @return string
	 */
	public function getSignDelim();

	/**
	 * @return string
	 */
	public function getDecimalPoint();

	/**
	 * @return int
	 */
	public function getFractionalDigits();

	/**
	 * @return string
	 */
	public function getThousandsSeparator();

	/**
	 * @return mixed[] = [
	 * 	'code' => string,
	 * 	'sign' => string,
	 * 	'sign_html' => string,
	 * 	'sign_position' => int,
	 * 	'sign_delim' => string,
	 * 	'decimal_point' => string,
	 * 	'frac_digits' => int,
	 * 	'thousands_sep' => string
	 * ]
	 */
	public function toArray();
}