<?php

namespace Shevsky\Discount4Review\Domain\Wa\Env;

use Exception;
use shopConfig;
use shopCurrencyModel;
use SystemConfig;
use waAppConfig;
use waRouting;
use waSystem;

class WaEnv
{
	private $systems = [];

	/**
	 * @param string $app
	 * @return waSystem
	 */
	public function getSystem($app = 'shop')
	{
		if (!isset($this->systems[$app]))
		{
			$this->systems[$app] = wa($app === 'wa' ? null : $app);
		}

		return $this->systems[$app];
	}

	/**
	 * @param string $app
	 * @return SystemConfig|waAppConfig|shopConfig
	 */
	public function getConfig($app = 'shop')
	{
		return $this->getSystem($app)->getConfig();
	}

	/**
	 * @param string $app
	 * @return string
	 */
	public function getVersion($app = 'shop')
	{
		return $this->getSystem($app)->getVersion();
	}

	/**
	 * @param string $version
	 * @param string $app
	 * @return bool
	 */
	public function compareVersion($version, $app = 'shop')
	{
		$app_version = $this->getVersion($app);

		return $app_version >= $version;
	}

	/**
	 * @return waRouting
	 */
	public function getRouting()
	{
		if (!isset($this->routing))
		{
			$this->routing = $this->getSystem()->getRouting();
		}

		return $this->routing;
	}

	/**
	 * @param string $domain
	 * @param array $route
	 * @return bool
	 */
	public function isAlias($domain, $route)
	{
		return !((!method_exists($this->getRouting(), 'isAlias') || !$this->getRouting()->isAlias($domain))
			and isset($route['url']));
	}

	/**
	 * @return mixed[]
	 */
	public function getCurrencyData()
	{
		return $this->getConfig()->getCurrency(false);
	}

	/**
	 * @return mixed
	 * @throws Exception
	 */
	public function getCurrencyCode()
	{
		$data = $this->getCurrencyData();

		if (!array_key_exists('code', $data)) {
			throw new Exception('Отсутствует параметр "code" для получения информации о валюте');
		}

		return $data['code'];
	}

	/**
	 * @return mixed[]
	 */
	public function getCurrencies()
	{
		$currency_model = new shopCurrencyModel();

		return $currency_model->getAll();
	}
}