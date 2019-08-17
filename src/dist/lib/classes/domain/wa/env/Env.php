<?php

namespace Shevsky\Discount4Review\Domain\Wa\Env;

use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Domain\Wa\Access\Storefront;
use Shevsky\Discount4Review\Domain\Wa\Access\Theme;
use Shevsky\Discount4Review\Persistence\Access\IStorefront;
use Shevsky\Discount4Review\Persistence\Access\ITheme;
use Shevsky\Discount4Review\Persistence\Env\IEnv;
use Shevsky\Discount4Review\Util\DefineUtil;
use Shevsky\Discount4Review\WaUtil\ThemeWaUtil;
use Exception;
use shopDiscount4reviewPlugin;
use waRequest;
use waTheme;

class Env implements IEnv
{
	private $plugin;
	private $wa_env;
	private $define_util;
	private $storefronts;
	private $themes;
	private $current_storefront;
	private $current_theme;

	private static $self;

	/**
	 * @param shopDiscount4reviewPlugin $plugin
	 */
	private function __construct(shopDiscount4reviewPlugin $plugin)
	{
		$this->plugin = $plugin;
		$this->wa_env = new WaEnv();
		$this->define_util = DefineUtil::getInstance($this);
		self::$self = $this;
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
	 * @return IStorefront[]
	 */
	public function getStorefronts()
	{
		if (!isset($this->storefronts))
		{
			$this->storefronts = [];

			$domains = $this->wa_env->getRouting()->getByApp('shop');
			foreach ($domains as $domain => $routes)
			{
				foreach ($routes as $route)
				{
					if ($this->wa_env->isAlias($domain, $route))
					{
						continue;
					}

					$storefront = new Storefront($domain, $route['url'], $this, $this->wa_env);
					$this->storefronts[] = $storefront;
				}
			}

			$this->sortStorefronts($this->storefronts);
			Context::dispatchEvent('env.storefronts', $this->storefronts);
		}

		return $this->storefronts;
	}

	/**
	 * @return IStorefront
	 * @throws Exception
	 */
	public function getCurrentStorefront()
	{
		if (!isset($this->current_storefront))
		{
			$route = $this->wa_env->getRouting()->getRoute();

			if ($route['app'] === 'shop')
			{
				$domain = $this->wa_env->getRouting()->getDomain();
				$route_url = $domain . '/' . $route['url'];

				$this->current_storefront = $this->define_util->defineStorefront($route_url);
			}
			else
			{
				throw new Exception("Не удалось определить используемую витрину");
			}
		}

		return $this->current_storefront;
	}

	/**
	 * @return ITheme[]
	 */
	public function getThemes()
	{
		if (!isset($this->themes))
		{
			$theme_util = new ThemeWaUtil($this->wa_env);
			$wa_themes = $theme_util->getThemes();

			$this->themes = array_values(array_map(
				function($wa_theme) use ($theme_util) {
					/**
					 * @var waTheme $wa_theme
					 */

					$theme = new Theme($wa_theme, $this, $this->wa_env);
					$theme->setStorefrontIds($theme_util->getStorefrontIds($wa_theme));

					return $theme;
				},
				$wa_themes
			));
			$this->sortThemes($this->themes);
			Context::dispatchEvent('env.themes', $this->themes);
		}

		return $this->themes;
	}

	/**
	 * @return ITheme
	 */
	public function getCurrentTheme()
	{
		if (!isset($this->current_theme))
		{
			$theme_id = waRequest::getTheme();

			/**
			 * @var Theme $current_theme
			 */
			$current_theme = $this->define_util->defineTheme($theme_id);

			$this->current_theme = $current_theme;
		}

		return $this->current_theme;
	}

	/**
	 * @param IStorefront[] $storefronts
	 */
	protected function sortStorefronts(array &$storefronts)
	{

	}

	/**
	 * @param ITheme[]
	 */
	protected function sortThemes(array &$themes)
	{
		usort(
			$themes,
			[__CLASS__, 'sortThemesCallable']
		);
	}

	/**
	 * @param Theme $theme
	 * @return bool
	 */
	private function sortThemesCallable(Theme $theme)
	{
		return !$theme->hasStorefronts();
	}
}