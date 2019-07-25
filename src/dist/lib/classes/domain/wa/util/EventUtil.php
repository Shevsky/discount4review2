<?php

namespace Shevsky\Discount4Review\Domain\Wa\Util;

use Shevsky\Discount4Review\Persistence\Util\IEventUtil;
use shopDiscount4reviewPlugin;

class EventUtil implements IEventUtil
{
	/**
	 * @param string $name
	 * @param mixed $params
	 * @return mixed
	 */
	public function dispatch($name, &$params = null)
	{
		$event_name = "discount4review_plugin.{$name}";

		return wa(shopDiscount4reviewPlugin::APP_ID)->event($event_name, $params);
	}

	/**
	 * @param string $name
	 * @param mixed $params
	 * @return mixed
	 */
	public function dispatchSystem($name, &$params = null)
	{
		return wa(shopDiscount4reviewPlugin::APP_ID)->event($name, $params);
	}
}