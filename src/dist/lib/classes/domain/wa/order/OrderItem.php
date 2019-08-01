<?php

namespace Shevsky\Discount4Review\Domain\Wa\Order;

use Exception;
use Shevsky\Discount4Review\Domain\Wa\Factory;
use Shevsky\Discount4Review\Persistence\Order\IOrderItem;
use Shevsky\Discount4Review\Persistence\Product\IProduct;
use Shevsky\Discount4Review\Persistence\Product\ISku;
use shopOrderItemsModel;

class OrderItem implements IOrderItem
{
	private $id;
	private $data;
	private $order_items_model;
	private $product;
	private $sku;

	/**
	 * @param mixed $data
	 * @throws Exception
	 */
	public function __construct($data)
	{
		$this->order_items_model = new shopOrderItemsModel();

		if (is_array($data))
		{
			if (array_key_exists('id', $data))
			{
				$this->id = (int)$data['id'];
				$this->data = $data;
			}
			else
			{
				throw new Exception('Неизвестные аргументы для построения экземпляра элемента заказа');
			}
		}
		elseif (is_numeric($data))
		{
			$this->id = (int)$data;
			$this->data = $this->order_items_model->getById($this->id);
		}

		if ($this->data['type'] !== 'product')
		{
			throw new Exception('Элемент заказа не является товаром');
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
	 * @return IProduct
	 * @throws Exception
	 */
	public function getProduct()
	{
		if (!isset($this->product))
		{
			$product_id = (int)$this->data['product_id'];

			$this->product = Factory::getInstance()->createProduct($product_id);
		}

		return $this->product;
	}

	/**
	 * @return ISku
	 * @throws Exception
	 */
	public function getSku()
	{
		if (!isset($this->sku))
		{
			$sku_id = (int)$this->data['sku_id'];

			$this->sku = Factory::getInstance()->createSku($this->getProduct(), $sku_id);
		}

		return $this->sku;
	}
}