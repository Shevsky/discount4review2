<?php

namespace Shevsky\Discount4Review\Persistence\Order;

interface IOrder
{
	/**
	 * @return int
	 */
	public function getId();

	/**
	 * @return IOrderItem[]
	 */
	public function getItems();
}