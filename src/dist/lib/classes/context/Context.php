<?php

namespace Shevsky\Discount4Review\Context;

use Shevsky\Discount4Review\Domain\Common\SettingsStorage\BasicSettingsStorage;
use Shevsky\Discount4Review\Domain\Common\SettingsStorage\StorefrontSettingsStorage;
use Shevsky\Discount4Review\Domain\Wa\Env\Env;
use Shevsky\Discount4Review\Domain\Wa\Factory;
use Shevsky\Discount4Review\Domain\Wa\Util\EventUtil;
use Shevsky\Discount4Review\Domain\Wa\Util\RoutingUtil;
use Shevsky\Discount4Review\Persistence\Registry;
use shopDiscount4reviewBasicSettingsModel;
use shopDiscount4reviewPlugin;
use shopDiscount4reviewStorefrontSettingsModel;

class Context
{
	use RouterAccess;
	use EventAccess;
	use PluginAccess;

	private $plugin;
	private $factory;
	private $registry;
	private $env;
	private $basic_settings_storage;
	private $storefront_settings_storage;
	private $routing_util;
	private $event_util;

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

	/**
	 * @return Env
	 */
	public function getEnv()
	{
		if (!isset($this->env))
		{
			$this->env = Env::getInstance();
		}

		return $this->env;
	}

	/**
	 * @return BasicSettingsStorage
	 */
	public function getBasicSettingsStorage()
	{
		if (!isset($this->basic_settings_storage))
		{
			$this->basic_settings_storage = new BasicSettingsStorage(new shopDiscount4reviewBasicSettingsModel());
		}

		return $this->basic_settings_storage;
	}

	/**
	 * @return StorefrontSettingsStorage
	 */
	public function getStorefrontSettingsStorage()
	{
		if (!isset($this->storefront_settings_storage))
		{
			$this->storefront_settings_storage = new StorefrontSettingsStorage(
				new shopDiscount4reviewStorefrontSettingsModel()
			);
		}

		return $this->storefront_settings_storage;
	}

	/**
	 * @return RoutingUtil
	 */
	public function getRoutingUtil()
	{
		if (!isset($this->routing_util))
		{
			$this->routing_util = new RoutingUtil();
		}

		return $this->routing_util;
	}

	/**
	 * @return EventUtil
	 */
	public function getEventUtil()
	{
		if (!isset($this->event_util))
		{
			$this->event_util = new EventUtil();
		}

		return $this->event_util;
	}
}