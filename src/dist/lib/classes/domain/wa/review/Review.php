<?php

namespace Shevsky\Discount4Review\Domain\Wa\Review;

use DateTime;
use Exception;
use Shevsky\Discount4Review\Domain\Wa\Factory;
use Shevsky\Discount4Review\Persistence\Order\IOrderItem;
use Shevsky\Discount4Review\Persistence\Product\IProduct;
use Shevsky\Discount4Review\Persistence\Product\ISku;
use Shevsky\Discount4Review\Persistence\Review\IAuthor;
use Shevsky\Discount4Review\Persistence\Review\IImage;
use Shevsky\Discount4Review\Persistence\Review\IReview;
use shopDiscount4reviewReviewModel;
use shopProductReviewsModel;

class Review implements IReview
{
	private $id;
	private $product_reviews_model;
	private $review_model;
	private $data;
	private $extend_data;
	private $product;
	private $sku;
	private $order_item;

	private $author;

	/**
	 * @param mixed $data
	 * @throws Exception
	 */
	public function __construct($data)
	{
		$this->product_reviews_model = new shopProductReviewsModel();
		$this->review_model = new shopDiscount4reviewReviewModel();

		if (is_numeric($data))
		{
			$this->id = $data;
			$this->data = $this->product_reviews_model->getById($this->id);
		}
		elseif (is_array($data))
		{
			if (!isset($data['id']))
			{
				$data['id'] = 0;
			}

			$this->id = (int)$data['id'];
			$this->data = $data;
		}
		else
		{
			throw new Exception('Неизвестные аргументы для построения экземпляра отзыва');
		}

		if ($this->id)
		{
			$this->extend_data = $this->review_model->getById($this->id);
			if (!is_array($this->extend_data))
			{
				$this->extend_data = [];
			}
		}
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return (int)$this->id;
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
	 * @return ISku|null
	 * @throws Exception
	 */
	public function getSku()
	{
		if (!isset($this->sku))
		{
			if (isset($this->extend_data['sku_id']))
			{
				$sku_id = (int)$this->extend_data['sku_id'];

				$this->sku = Factory::getInstance()->createSku($this->getProduct(), $sku_id);
			}
			else
			{
				$this->sku = false;
			}
		}

		return $this->sku === false ? null : $this->sku;
	}

	/**
	 * @param ISku $sku
	 */
	public function setSku(ISku $sku)
	{
		$this->sku = $sku;
		$this->extend_data['sku_id'] = $sku->getId();
	}

	/**
	 * @return IOrderItem|null
	 * @throws Exception
	 */
	public function getOrderItem()
	{
		if (!isset($this->order_item))
		{
			if (isset($this->extend_data['order_item_id']))
			{
				$order_item_id = (int)$this->extend_data['order_item_id'];

				$this->order_item = Factory::getInstance()->createOrderItem($order_item_id);
			}
			else
			{
				$this->order_item = false;
			}
		}

		return $this->order_item === false ? null : $this->order_item;
	}

	/**
	 * @param IOrderItem $order_item
	 */
	public function setOrderItem(IOrderItem $order_item)
	{
		$this->order_item = $order_item;
		$this->extend_data['order_item_id'] = $order_item->getId();
	}

	/**
	 * Возвращает источник - откуда был добавлен отзыв
	 * @return string[order]
	 * @return string[product]
	 */
	public function getOrigin()
	{
		if (isset($this->extend_data['origin']))
		{
			return $this->extend_data['origin'];
		}

		return 'product';
	}

	/**
	 * @return float
	 */
	public function getRate()
	{
		return (float)$this->data['rate'];
	}

	/**
	 * @return IAuthor
	 */
	public function getAuthor()
	{
		if (!isset($this->author))
		{
			$this->author = new Author(
				$this->data['contact_id'],
				$this->data['name'],
				$this->data['email'],
				$this->data['ip']
			);
		}

		return $this->author;
	}

	/**
	 * @return DateTime
	 */
	public function getDateTime()
	{
		return new DateTime($this->data['datetime']);
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->data['title'];
	}

	/**
	 * @return string
	 */
	public function getText()
	{
		return $this->data['text'];
	}

	/**
	 * @return IImage[]
	 */
	public function getImages()
	{
		return [];
	}

	public function save()
	{
		$this->review_model->insert(
			array_merge(
				[
					'id' => $this->getId(),
				],
				$this->extend_data
			),
			1
		);
	}
}