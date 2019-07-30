<?php

namespace Shevsky\Discount4Review\Domain\Wa\Review;

use DateTime;
use Exception;
use Shevsky\Discount4Review\Domain\Wa\Factory;
use Shevsky\Discount4Review\Persistence\Product\IProduct;
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
			$extend_data = $this->review_model->getById($this->id);
			if (!is_array($extend_data))
			{
				$extend_data = [];
			}
			$this->data = array_merge($this->data, $extend_data);
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
	 */
	public function getProduct()
	{
		$product_id = (int)$this->data['product_id'];

		return Factory::getInstance()->createProduct($product_id);
	}

	/**
	 * Возвращает источник - откуда был добавлен отзыв
	 * @return string[order]
	 * @return string[product]
	 */
	public function getOrigin()
	{
		if (isset($this->data['origin']))
		{
			return $this->data['origin'];
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
}