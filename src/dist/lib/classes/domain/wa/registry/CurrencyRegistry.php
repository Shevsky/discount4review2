<?php

namespace Shevsky\Discount4Review\Domain\Wa\Registry;

use Exception;
use Shevsky\Discount4Review\Persistence\Access\ICurrency;
use Shevsky\Discount4Review\Persistence\IFactory;
use shopConfig;
use waCurrency;
use waLocale;
use waSystem;

class CurrencyRegistry
{
	private $factory;
	private $registry = [];
	private $system;

	/**
	 * @param IFactory $factory
	 */
	public function __construct(IFactory $factory)
	{
		$this->factory = $factory;
	}

	/**
	 * @param string $code
	 * @return ICurrency
	 */
	public function getByCode($code)
	{
		if (!isset($this->registry[$code]))
		{
			$this->registry[$code] = self::buildByCode($code);
		}

		return $this->registry[$code];
	}

	/**
	 * @param array $data
	 * @return ICurrency
	 * @throws Exception
	 */
	public function getByData(array $data)
	{
		if (!array_key_exists('code', $data))
		{
			throw new Exception('Отсутствует параметр "code" для построения экземпляра валюты');
		}

		$code = $data['code'];
		if (!isset($this->registry[$code]))
		{
			$this->registry[$code] = self::buildByData($data);
		}

		return $this->registry[$code];
	}

	/**
	 * @param string $code
	 * @return ICurrency
	 */
	private function buildByCode($code)
	{
		$currency = waCurrency::getInfo($code);
		$locale = waLocale::getInfo($this->getLocale());

		$data = [
			'code' => $currency['code'],
			'sign' => $currency['sign'],
			'sign_html' => !empty($currency['sign_html']) ? $currency['sign_html'] : $currency['sign'],
			'sign_position' => isset($currency['sign_position']) ? (int)$currency['sign_position'] : 1,
			'sign_delim' => isset($currency['sign_delim']) ? $currency['sign_delim'] : ' ',
			'decimal_point' => isset($locale['decimal_point']) ? $locale['decimal_point'] : ',',
			'frac_digits' => isset($locale['frac_digits']) ? (int)$locale['frac_digits'] : 0,
			'thousands_sep' => isset($locale['thousands_sep']) ? $locale['thousands_sep'] : '.',
		];

		return $this->buildByData($data);
	}

	/**
	 * @param array $data
	 * @return ICurrency
	 */
	private function buildByData(array $data)
	{
		return $this->factory->createCurrency($data);
	}

	/**
	 * @return waSystem
	 */
	private function getSystem()
	{
		if (!isset($this->system))
		{
			$this->system = wa('shop');
		}

		return $this->system;
	}

	/**
	 * @return shopConfig
	 */
	private function getSystemConfig()
	{
		return $this->getSystem()->getConfig();
	}

	/**
	 * @return string
	 */
	private function getLocale()
	{
		return $this->getSystem()->getLocale();
	}
}