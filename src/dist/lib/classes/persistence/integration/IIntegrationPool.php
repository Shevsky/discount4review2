<?php

namespace Shevsky\Discount4Review\Persistence\Integration;

interface IIntegrationPool
{
	/**
	 * @param string $name
	 * @return IIntegration
	 */
	public function getIntegration($name);

	/**
	 * @param string $name
	 * @return bool
	 */
	public function isAvailableIntegration($name);
}