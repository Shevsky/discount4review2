<?php

namespace Shevsky\Discount4Review\Domain\Wa\Handler;

use Exception;
use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Domain\Common\Handler\Handler;
use Shevsky\Discount4Review\Domain\Wa\Factory;
use Shevsky\Discount4Review\Domain\Wa\Order\OrderItem;
use Shevsky\Discount4Review\Domain\Wa\Product\Product;
use Shevsky\Discount4Review\Domain\Wa\Review\Review;
use waRequest;

/**
 * @property OrderItem $order_item
 */
class ReviewAddAfterHandler extends Handler
{
	private $product;
	private $review;
	private $order_item_id;
	private $order_item;

	/**
	 * @param Product $product
	 * @param Review $review
	 * @throws Exception
	 */
	public function __construct(Product $product, Review $review)
	{
		if (!Context::getPluginStatus())
		{
			throw new Exception('Обработчик недоступен');
		}

		$this->product = $product;
		$this->review = $review;
	}

	public function execute()
	{
		$this->restoreOrderItem();
		$this->setOrderItem2Review();
		$this->setSku2Review();

		$this->review->save();
	}

	private function restoreOrderItem()
	{
		$key = 'd4r_review_order_item_id';

		$stored_data = wa()->getStorage()->read($key);
		if (!is_array($stored_data) || empty($stored_data))
		{
			return;
		}

		if (array_key_exists($this->product->getId(), $stored_data))
		{
			try
			{
				$this->order_item_id = (int)$stored_data[$this->product->getId()];
				$this->order_item = Factory::getInstance()->createOrderItem($this->order_item_id);
			}
			catch (Exception $e)
			{
			}
		}
	}

	private function setOrderItem2Review()
	{
		if (!isset($this->order_item))
		{
			return;
		}

		$this->review->setOrderItem($this->order_item);
	}

	private function setSku2Review()
	{
		if (!isset($this->order_item))
		{
			return;
		}

		try
		{
			$sku = $this->order_item->getSku();

			$this->review->setSku($sku);
		}
		catch (Exception $e)
		{
		}
	}
}