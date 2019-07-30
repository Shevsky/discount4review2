<?php

namespace Shevsky\Discount4Review\Domain\Wa\Handler;

use Exception;
use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Domain\Common\Handler\Handler;
use Shevsky\Discount4Review\Domain\Wa\Product\Product;
use Shevsky\Discount4Review\Domain\Wa\Review\Review;
use waRequest;

class ReviewAddBeforeHandler extends Handler
{
	private $product;
	private $review;
	private $item_id = 0;

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
		$this->restoreItemId();

		wa_dump($this->item_id);
	}

	private function restoreItemId()
	{
		$key = 'd4r_review_item_id';

		$stored_data = wa()->getStorage()->read($key);
		if (!is_array($stored_data) || empty($stored_data))
		{
			return;
		}

		if (array_key_exists($this->product->getId(), $stored_data))
		{
			$this->item_id = (int)$stored_data[$this->product->getId()];
		}
	}
}