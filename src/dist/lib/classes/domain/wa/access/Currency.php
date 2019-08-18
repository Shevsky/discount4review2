<?php

namespace Shevsky\Discount4Review\Domain\Wa\Access;

use Shevsky\Discount4Review\Persistence\Access\ICurrency;

class Currency implements ICurrency
{
	protected $data;

	/**
	 * @param mixed[] $data = [
	 *    'code' => string,
	 *    'sign' => string,
	 *    'sign_html' => string,
	 *    'sign_position' => int,
	 *    'sign_delim' => string,
	 *    'decimal_point' => string,
	 *    'frac_digits' => int,
	 *    'thousands_sep' => string
	 * ]
	 */
	public function __construct(array $data)
	{
		$this->data = $data;
	}

	/**
	 * @return string
	 */
	public function getCode()
	{
		return $this->data['code'];
	}

	/**
	 * @return string
	 */
	public function getSign()
	{
		return $this->data['sign'];
	}

	/**
	 * @return string
	 */
	public function getSignHtml()
	{
		return $this->data['sign_html'];
	}

	/**
	 * @return int
	 */
	public function getSignPosition()
	{
		return $this->data['sign_position'];
	}

	/**
	 * @return string
	 */
	public function getSignDelim()
	{
		return $this->data['sign_delim'];
	}

	/**
	 * @return string
	 */
	public function getDecimalPoint()
	{
		return $this->data['decimal_point'];
	}

	/**
	 * @return int
	 */
	public function getFractionalDigits()
	{
		return $this->data['frac_digits'];
	}

	/**
	 * @return string
	 */
	public function getThousandsSeparator()
	{
		return $this->data['thousands_sep'];
	}

	/**
	 * @return mixed[] = [
	 *    'code' => string,
	 *    'sign' => string,
	 *    'sign_html' => string,
	 *    'sign_position' => int,
	 *    'sign_delim' => string,
	 *    'decimal_point' => string,
	 *    'frac_digits' => int,
	 *    'thousands_sep' => string
	 * ]
	 */
	public function toArray()
	{
		return $this->data;
	}
}