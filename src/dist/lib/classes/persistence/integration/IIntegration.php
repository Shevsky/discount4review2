<?php

namespace Shevsky\Discount4Review\Persistence\Integration;

interface IIntegration
{
	/**
	 * @return bool
	 */
	public function isAvailable();
}