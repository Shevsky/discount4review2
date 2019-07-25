<?php

namespace Shevsky\Discount4Review\Util;

use Shevsky\Discount4Review\Domain\Wa\Env\Env;
use Shevsky\Discount4Review\Persistence\Access\IStorefront;
use Shevsky\Discount4Review\Persistence\Access\ITheme;
use Shevsky\Discount4Review\Persistence\Env\IEnv;

class DefineUtil
{
	private $env;

	private static $self;

	/**
	 * @param IEnv $env
	 */
	private function __construct(IEnv $env)
	{
		$this->env = $env;
		self::$self = $this;
	}

	/**
	 * @param IEnv $env
	 * @return self
	 */
	public static function getInstance(IEnv $env = null)
	{
		if (!isset(self::$self))
		{
			if (!isset($env))
			{
				$env = Env::getInstance();
			}
			self::$self = new self($env);
		}

		return self::$self;
	}

	/**
	 * @param string[] $storefront_ids
	 * @return IStorefront[]
	 */
	public function defineStorefronts(...$storefront_ids)
	{
		$storefronts = $this->env->getStorefronts();

		return array_filter(
			$storefronts,
			function($storefront) use ($storefront_ids) {
				/**
				 * @var IStorefront $storefront
				 */

				return in_array($storefront->getId(), $storefront_ids);
			}
		);
	}

	/**
	 * @param string $storefront_id
	 * @return IStorefront
	 */
	public function defineStorefront($storefront_id)
	{
		$defined_storefronts = $this->defineStorefronts($storefront_id);
		if (empty($defined_storefronts))
		{
			return null;
		}

		return current($defined_storefronts);
	}

	/**
	 * @param string[] $theme_ids
	 * @return ITheme[]
	 */
	public function defineThemes(...$theme_ids)
	{
		$themes = $this->env->getThemes();

		return array_filter(
			$themes,
			function($theme) use ($theme_ids) {
				/**
				 * @var ITheme $theme
				 */

				return in_array($theme->getId(), $theme_ids);
			}
		);
	}

	/**
	 * @param string $theme_id
	 * @return ITheme
	 */
	public function defineTheme($theme_id)
	{
		$defined_themes = $this->defineThemes($theme_id);
		if (empty($defined_themes))
		{
			return null;
		}

		return current($defined_themes);
	}
}