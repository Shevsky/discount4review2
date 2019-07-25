<?php

namespace Shevsky\Discount4Review\Domain\Wa\Access;

use Shevsky\Discount4Review\Domain\Wa\Env\Env;
use Shevsky\Discount4Review\Domain\Wa\Env\WaEnv;
use Shevsky\Discount4Review\Persistence\Access\IStorefront;
use Shevsky\Discount4Review\Persistence\Access\ITheme;
use Shevsky\Discount4Review\Util\DefineUtil;

class Storefront implements IStorefront
{
	private $domain;
	private $route;
	private $env;
	private $wa_env;

	/**
	 * @param string $domain
	 * @param string $route
	 * @param Env $env
	 * @param WaEnv $wa_env
	 */
	public function __construct($domain, $route, Env $env, WaEnv $wa_env)
	{
		$this->domain = $domain;
		$this->route = $route;
		$this->env = $env;
		$this->wa_env = $wa_env;
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return "{$this->domain}/{$this->route}";
	}

	/**
	 * @return string
	 */
	public function getDomain()
	{
		return $this->domain;
	}

	/**
	 * @return string
	 */
	public function getRoute()
	{
		return $this->route;
	}

	/**
	 * @return mixed[] = [
	 *  'url' => string,
	 *  'module' => string,
	 *  'action' => string,
	 *  'app' => string,
	 *  'theme' => string
	 * ]
	 */
	private function getShopRoute()
	{
		foreach ($this->wa_env->getRouting()->getByApp('shop') as $domain => $routes)
		{
			foreach ($routes as $route)
			{
				if (!isset($route['url']) || $this->wa_env->isAlias($domain, $route))
				{
					continue;
				}

				$route_url = $domain . '/' . $route['url'];

				if ($route_url === $this->getId())
				{
					return $route;
				}
			}
		}

		return [];
	}

	/**
	 * @return string
	 */
	private function getThemeId()
	{
		$route = $this->getShopRoute();
		if (!isset($route['Theme']))
		{
			return null;
		}

		return $route['Theme'];
	}

	/**
	 * @return ITheme
	 */
	public function getTheme()
	{
		return DefineUtil::getInstance($this->env)->defineTheme($this->getThemeId());
	}

	/**
	 * @param string[] $excluded_rows
	 * @return mixed[] = [
	 *  'id' => string,
	 *  'domain' => string,
	 *  'route' => string,
	 *  'theme' => mixed[]
	 * ]
	 */
	public function toArray(array $excluded_rows = [])
	{
		$rows = [
			'id' => $this->getId(),
			'domain' => $this->getDomain(),
			'route' => $this->getRoute(),
		];

		if (!in_array('theme', $excluded_rows))
		{
			$theme = $this->getTheme();
			if (!$theme)
			{
				$rows['theme'] = $theme;
			}
			else
			{
				$rows['theme'] = $theme->toArray(['storefronts']);
			}
		}

		return $rows;
	}
}