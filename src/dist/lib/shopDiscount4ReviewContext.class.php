<?php

class shopDiscount4ReviewContext
{
	private $plugin;

	private $factory;
	private $registry;

	private static $self;

	/**
	 * @param shopDiscount4ReviewPlugin $plugin
	 */
	public function __construct(shopDiscount4ReviewPlugin $plugin)
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
			self::$self = new self(shopDiscount4ReviewPlugin::getInstance());
		}

		return self::$self;
	}

	/**
	 * @return shopDiscount4ReviewFactory
	 */
	public function getFactory()
	{
		if (!isset($this->factory))
		{
			$this->factory = new shopDiscount4ReviewFactory();
		}

		return $this->factory;
	}

	/**
	 * @return shopDiscount4ReviewRegistry
	 */
	public function getRegistry()
	{
		if (!isset($this->registry))
		{
			$this->registry = new shopDiscount4ReviewRegistry($this->getFactory());
		}

		return $this->registry;
	}
}