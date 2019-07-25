<?php

namespace Shevsky\Discount4Review\WaUtil;

use Shevsky\Discount4Review\Domain\Wa\Env\WaEnv;
use waTheme;

class ThemeWaUtil
{
	private $wa_env;
	private $shop_routing;
	private $shop_themes;
	private $is_themes_fully_loaded = false;
	private $themes;

	/**
	 * @param WaEnv $wa_env
	 */
	public function __construct(WaEnv $wa_env)
	{
		$this->wa_env = $wa_env;
	}

	/**
	 * @return array[] = [
	 *  $domain => [
	 *      'theme' => string,
	 *      'module' => string,
	 *      'action' => string,
	 *      'app' => string
	 *  ]
	 * ]
	 */
	protected function getShopRouting()
	{
		if (!isset($this->shop_routing))
		{
			$this->shop_routing = $this->wa_env->getRouting()->getByApp('shop');
		}

		return $this->shop_routing;
	}

	/**
	 * @return waTheme[]
	 */
	protected function getShopThemes()
	{
		if (!isset($this->shop_themes))
		{
			$this->shop_themes = $this->wa_env->getSystem()->getThemes('shop');
		}

		return $this->shop_themes;
	}

	/**
	 * @return string|null
	 */
	protected function getFirstThemeId()
	{
		$first_theme_id = null;

		$shop_routing = $this->getShopRouting();
		foreach ($shop_routing as $domain => $routes)
		{
			foreach ($routes as $route)
			{
				if (!array_key_exists('theme', $route))
				{
					continue;
				}

				$first_theme_id = $route['theme'];

				break 2;
			}
		}

		return $first_theme_id;
	}

	/**
	 * @return waTheme[] = [
	 *  $theme_id => waTheme
	 * ]
	 */
	public function getThemes()
	{
		if (!isset($this->themes) || !$this->is_themes_fully_loaded)
		{
			$themes = [];

			$first_theme_id = $this->getFirstThemeId();
			$first_theme = null;

			$shop_themes = $this->getShopThemes();
			foreach ($shop_themes as $theme)
			{
				$is_first = $first_theme_id === $theme->id;
				if ($is_first)
				{
					$first_theme = $theme;
					continue;
				}

				$themes[$theme->id] = $theme;
			}

			if (isset($first_theme))
			{
				$this->themes = [
						$first_theme_id => $first_theme,
					] + $themes;
			}
			else
			{
				$this->themes = $themes;
			}

			$this->is_themes_fully_loaded = true;
		}

		return $this->themes;
	}

	/**
	 * @param waTheme $wa_theme
	 * @return string[]
	 */
	public function getStorefrontIds(waTheme $wa_theme)
	{
		$storefront_ids = [];

		$shop_routing = $this->getShopRouting();
		foreach ($shop_routing as $domain => $routes)
		{
			foreach ($routes as $route)
			{
				if (!array_key_exists('theme', $route))
				{
					continue;
				}

				$route_url = $domain . '/' . $route['url'];

				if ($route['theme'] === $wa_theme->id)
				{
					$storefront_ids[] = $route_url;
				}
			}
		}

		return $storefront_ids;
	}
}