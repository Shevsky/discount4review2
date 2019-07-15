<?php

namespace Discount4Review;

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
	public function __construct(shopDiscount4reviewPlugin $plugin)
	{
		$this->plugin = $plugin;
	}

	/**
	 * @return self
	 */
	public static function getInstance()
	{
		if (!isset(self::$self))
		{
			self::$self = new self(shopDiscount4reviewPlugin::getInstance());
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