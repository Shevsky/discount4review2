<?php

namespace Shevsky\Discount4Review\Context;

use Shevsky\Discount4Review\Domain\Factory;
use Shevsky\Discount4Review\Persistence\Registry;
use shopDiscount4reviewPlugin;

class Context
{
	private $plugin;

	private $factory;
	private $registry;

	private static $self;

	/**
	 * @param shopDiscount4reviewPlugin $plugin
	 */
	private function __construct(shopDiscount4reviewPlugin $plugin)
	{
		$this->plugin = $plugin;
	}

	/**
	 * @param shopDiscount4reviewPlugin $plugin
	 * @return self
	 */
	public static function getInstance(shopDiscount4reviewPlugin $plugin = null)
	{
		if (!isset(self::$self))
		{
			if (!isset($plugin))
			{
				$plugin = shopDiscount4reviewPlugin::getInstance();
			}
			self::$self = new self($plugin);
		}

		return self::$self;
	}

	/**
	 * @return Factory
	 */
	public function getFactory()
	{
		if (!isset($this->factory))
		{
			$this->factory = new Factory();
		}

		return $this->factory;
	}

	/**
	 * @return Registry
	 */
	public function getRegistry()
	{
		if (!isset($this->registry))
		{
			$this->registry = new Registry($this->getFactory());
		}

		return $this->registry;
	}
}