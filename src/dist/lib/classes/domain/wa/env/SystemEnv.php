<?php

namespace Shevsky\Discount4Review\Domain\Wa\Env;

use Shevsky\Discount4Review\Persistence\Env\ISystemEnv;
use shopDiscount4reviewPlugin;

class SystemEnv implements ISystemEnv
{
	private $plugin;
	private $wa_env;

	private static $self;

	/**
	 * @param shopDiscount4reviewPlugin $plugin
	 */
	private function __construct(shopDiscount4reviewPlugin $plugin)
	{
		$this->plugin = $plugin;
		$this->wa_env = WaEnv::getInstance();
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
	 * @return boolean
	 */
	public function isReviewImagesAllowed()
	{
		return $this->wa_env->getVersion('shop') >= '8.4.6';
	}
}