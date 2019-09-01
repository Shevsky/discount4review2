<?php

namespace Shevsky\Discount4Review\Persistence\Order;

interface IOrderAction
{
	/**
	 * @return string
	 */
	public function getId();

	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return mixed[] = [
	 *  'id' => string,
	 *  'name' => string
	 * ]
	 */
	public function toArray();
}