<?php

namespace Shevsky\Discount4Review\Context;

use Shevsky\Discount4Review\Domain\Common\SettingsStorage\BasicSettingsStorage;
use Shevsky\Discount4Review\Domain\Common\SettingsStorage\StorefrontSettingsStorage;
use Shevsky\Discount4Review\Domain\Wa\Env\Env;
use Shevsky\Discount4Review\Domain\Wa\Factory;
use Shevsky\Discount4Review\Domain\Wa\Registry\CurrencyRegistry;
use Shevsky\Discount4Review\Domain\Wa\Registry\UserGroupRegistry;
use Shevsky\Discount4Review\Domain\Wa\Util\EventUtil;
use Shevsky\Discount4Review\Domain\Wa\Util\RoutingUtil;
use Shevsky\Discount4Review\Service\FrontendService;
use Shevsky\Discount4Review\Service\SettingsService;
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
	private $env;
	private $basic_settings_storage;
	private $storefront_settings_storage;
	private $settings_service;
	private $frontend_service;
	private $currency_registry;
	private $user_group_registry;
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
			$this->factory = Factory::getInstance();
		}

		return $this->factory;
	}

	/**
	 * @return Env
	 */
	public function getEnv()
	{
		if (!isset($this->env))
		{
			$this->env = Env::getInstance($this->plugin);
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
	 * @return SettingsService
	 */
	public function getSettingsService()
	{
		if (!isset($this->settings_service))
		{
			$this->settings_service = new SettingsService(
				$this->getEnv(),
				$this->getBasicSettingsStorage(),
				$this->getStorefrontSettingsStorage()
			);
		}

		return $this->settings_service;
	}

	/**
	 * @return FrontendService
	 */
	public function getFrontendService()
	{
		if (!isset($this->frontend_service))
		{
			$this->frontend_service = new FrontendService(
				$this->getSettingsService(),
				$this->getEnv()
			);
		}

		return $this->frontend_service;
	}

	/**
	 * @return CurrencyRegistry
	 */
	public function getCurrencyRegistry()
	{
		if (!isset($this->currency_registry))
		{
			$this->currency_registry = new CurrencyRegistry($this->getFactory());
		}

		return $this->currency_registry;
	}

	/**
	 * @return UserGroupRegistry
	 */
	public function getUserGroupRegistry()
	{
		if (!isset($this->user_group_registry))
		{
			$this->user_group_registry = new UserGroupRegistry($this->getFactory());
		}

		return $this->user_group_registry;
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