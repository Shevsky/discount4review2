<?php

class shopDiscount4ReviewReview implements shopDiscount4ReviewIReview
{
	private $id;
	private $product_reviews_model;
	private $review_model;
	private $data;

	private $author;

	/**
	 * @param int $id
	 */
	public function __construct($id)
	{
		$this->id = $id;
		$this->product_reviews_model = new shopProductReviewsModel();
		$this->review_model = new shopDiscount4ReviewReviewModel();

		$this->data = $this->product_reviews_model->getById($this->id);
		$extend_data = $this->review_model->getById($this->id);
		if (!is_array($extend_data))
		{
			$extend_data = [];
		}
		$this->data = array_merge($this->data, $extend_data);
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return (int)$this->id;
	}

	/**
	 * @return shopDiscount4ReviewIProduct
	 */
	public function getProduct()
	{
		$product_id = (int)$this->data['product_id'];

		return shopDiscount4ReviewContext::getInstance()->getRegistry()->getProduct($product_id);
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
	 * @return shopDiscount4ReviewIReviewAuthor
	 */
	public function getAuthor()
	{
		if (!isset($this->author))
		{
			$this->author = new shopDiscount4ReviewReviewAuthor(
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
	 * @return shopDiscount4ReviewIReviewImage[]
	 */
	public function getImages()
	{
		// TODO: Implement getImages() method.
		throw new Exception('[getImages] not implemented');
	}
}