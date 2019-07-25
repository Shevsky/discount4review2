<?php

namespace Shevsky\Discount4Review\Persistence\Util;

interface IEventUtil
{
	/**
	 * @param string $name
	 * @param mixed $params
	 * @return mixed
	 */
	public function dispatch($name, &$params = null);

	/**
	 * @param string $name
	 * @param mixed $params
	 * @return mixed
	 */
	public function dispatchSystem($name, &$params = null);
}