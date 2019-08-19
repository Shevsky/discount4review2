<?php

namespace Shevsky\Discount4Review\Domain\Wa\Env;

use Exception;
use shopConfig;
use shopCurrencyModel;
use SystemConfig;
use waAppConfig;
use waContactCategoriesModel;
use waContactCategoryModel;
use waException;
use waRouting;
use waSystem;

class WaEnv
{
	private $systems = [];

	private static $self;

	private function __construct()
	{
	}

	/**
	 * @return self
	 */
	public static function getInstance()
	{
		if (!isset(self::$self))
		{
			self::$self = new self();
		}

		return self::$self;
	}

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
	public function getCurrencyCode()
	{
		return $this->getConfig()->getCurrency(false);
	}

	/**
	 * @return mixed[]
	 */
	public function getCurrencies()
	{
		$currency_model = new shopCurrencyModel();

		return $currency_model->getAll();
	}

	/**
	 * @return mixed[]
	 */
	public function getContactCategoryArray()
	{
		$contact_category_model = new waContactCategoryModel();

		return $contact_category_model->getAll();
	}

	/**
	 * @return int[]
	 */
	public function getContactCategoriesIds()
	{
		$contact_categories_model = new waContactCategoriesModel();

		try
		{
			$contact_categories = $contact_categories_model->getByField(
				'contact_id',
				wa()->getUser()->getId(),
				'category_id'
			);
		}
		catch (waException $e)
		{
			return [];
		}

		if (!is_array($contact_categories))
		{
			return [];
		}

		return array_keys($contact_categories);
	}
}