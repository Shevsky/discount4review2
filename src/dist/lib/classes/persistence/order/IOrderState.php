<?php

namespace Shevsky\Discount4Review\Persistence\Order;

interface IOrderState
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
	 * @return string
	 */
	public function getColor();

	/**
	 * @return string
	 */
	public function getIcon();

	/**
	 * @return mixed[] = [
	 *  'id' => string,
	 *  'name' => string,
	 *  'color' => string,
	 *  'icon' => string
	 * ]
	 */
	public function toArray();
}