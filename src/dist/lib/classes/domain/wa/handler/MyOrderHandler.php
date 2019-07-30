<?php

namespace Shevsky\Discount4Review\Domain\Wa\Handler;

use Exception;
use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Domain\Common\Handler\Handler;

class MyOrderHandler extends Handler
{
	private $order;

	/**
	 * @param mixed $order
	 * @throws Exception
	 */
	public function __construct($order)
	{
		if (!Context::getPluginStatus()
			|| !Context::getInstance()->getSettingsService()->storefront->getMyOrderAutoInjectStatus())
		{
			throw new Exception('Обработчик недоступен');
		}

		$this->order = $order;
	}

	/**
	 * @return mixed
	 * @throws Exception
	 */
	public function execute()
	{
		return Context::getInstance()->getFrontendService()->renderMyOrder(
			[
				'order' => $this->order,
			]
		);
	}
}