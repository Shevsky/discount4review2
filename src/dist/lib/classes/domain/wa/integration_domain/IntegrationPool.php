<?php

namespace Shevsky\Discount4Review\Domain\Wa\IntegrationDomain;

use Exception;
use Shevsky\Discount4Review\Persistence\Integration\IIntegration;
use Shevsky\Discount4Review\Persistence\Integration\IIntegrationPool;

class IntegrationPool implements IIntegrationPool
{
	private $pool = [];

	/**
	 * @param string $name
	 * @return IIntegration
	 * @throws Exception
	 */
	public function getIntegration($name)
	{
		if (!isset($this->pool[$name]))
		{
			if ($name === 'flexdiscount')
			{
				$integration = new FlexDiscountIntegration();
			}
			else
			{
				throw new Exception("Интеграция \"{$name}\" недоступна");
			}

			$this->pool[$name] = $integration;
		}

		return $this->pool[$name];
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function isAvailableIntegration($name)
	{
		try
		{
			return $this->getIntegration($name)->isAvailable();
		}
		catch (Exception $e)
		{
			return false;
		}
	}
}