<?php

namespace Shevsky\Discount4Review\Domain\Wa\Order;

use Shevsky\Discount4Review\Persistence\Order\IOrderState;

class OrderState implements IOrderState
{
	protected $data;

	/**
	 * @param mixed[] $data = [
	 *  'id' => string,
	 *  'name' => string,
	 *  'color' => string,
	 *  'icon' => string
	 * ]
	 */
	public function __construct(array $data)
	{
		$this->data = $data;
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->data['id'];
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->data['name'];
	}

	/**
	 * @return string
	 */
	public function getColor()
	{
		return $this->data['color'];
	}

	/**
	 * @return string
	 */
	public function getIcon()
	{
		return $this->data['icon'];
	}

	/**
	 * @return mixed[] = [
	 *  'id' => string,
	 *  'name' => string,
	 *  'color' => string,
	 *  'icon' => string
	 * ]
	 */
	public function toArray()
	{
		return $this->data;
	}
}