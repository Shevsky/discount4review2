<?php

namespace Shevsky\Discount4Review\Domain\Wa\Handler;

use Exception;
use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Domain\Common\Handler\Handler;
use Shevsky\Discount4Review\Domain\Wa\Product\Product;
use waRequest;

class ReviewsPageHandler extends Handler
{
	private $product;
	private $item_id;

	/**
	 * @param Product $product
	 * @throws Exception
	 */
	public function __construct(Product $product)
	{
		if (!Context::getPluginStatus() || waRequest::param('action') !== 'productReviews')
		{
			throw new Exception('Обработчик недоступен');
		}

		$this->product = $product;
		$this->item_id = waRequest::get('d4r_item_id', 0, waRequest::TYPE_INT);
	}

	public function execute()
	{
		$this->storeItemId();
	}

	private function storeItemId()
	{
		$key = 'd4r_review_item_id';

		$stored_data = wa()->getStorage()->read($key);
		if (!is_array($stored_data))
		{
			$stored_data = [];
		}

		$stored_data[$this->product->getId()] = $this->item_id;

		wa()->getStorage()->write($key, $stored_data);
	}
}