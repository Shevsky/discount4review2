<?php

namespace Shevsky\Discount4Review\Domain\Wa\Order;

use Exception;
use Shevsky\Discount4Review\Persistence\Order\IOrder;
use Shevsky\Discount4Review\Persistence\Order\IOrderItem;
use shopOrderModel;

class Order implements IOrder
{
	private $id;
	private $data;
	private $order_model;
	private $items;

	/**
	 * @param mixed $data
	 */
	public function __construct($data)
	{
		$this->order_model = new shopOrderModel();

		if (is_array($data))
		{
			if (array_key_exists('id', $data))
			{
				$this->id = (int)$data['id'];
				$this->data = $data;
			}
			else
			{
				throw new Exception('Неизвестные аргументы для построения экземпляра заказа');
			}
		}
		elseif (is_numeric($data))
		{
			$this->id = (int)$data;
			$this->data = $this->order_model->getOrder($this->id);
		}
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return IOrderItem
	 */
	public function getItems()
	{
		if (!isset($this->items))
		{
			if (!empty($this->data['items']) && is_array($this->data['items']))
			{
				$this->items = array_values(
					array_map(
						function($_item) {
							return new OrderItem($_item);
						},
						$this->data['items']
					)
				);
			}
			else
			{
				$this->items = [];
			}
		}

		return $this->items;
	}
}