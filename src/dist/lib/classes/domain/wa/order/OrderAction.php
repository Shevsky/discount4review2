<?php

namespace Shevsky\Discount4Review\Domain\Wa\Order;

use Shevsky\Discount4Review\Persistence\Order\IOrderAction;

class OrderAction implements IOrderAction
{
	protected $data;

	/**
	 * @param mixed[] $data = [
	 *  'id' => string,
	 *  'name' => string
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
	 * @return mixed[] = [
	 *  'id' => string,
	 *  'name' => string
	 * ]
	 */
	public function toArray()
	{
		return $this->data;
	}
}