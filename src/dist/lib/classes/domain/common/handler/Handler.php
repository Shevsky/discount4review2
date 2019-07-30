<?php

namespace Shevsky\Discount4Review\Domain\Common\Handler;

use Shevsky\Discount4Review\Persistence\Handler\IHandler;

abstract class Handler implements IHandler
{
	/**
	 * @param mixed ...$params
	 * @return mixed
	 */
	public static function dispatch(...$params)
	{
		$handler = new static(...$params);

		return $handler->execute();
	}
}