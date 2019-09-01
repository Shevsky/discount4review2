<?php

namespace Shevsky\Discount4Review\Domain\Common\SettingsConfig;

use Shevsky\Discount4Review\Persistence\Settings\ISettingsConfig;
use Shevsky\Discount4Review\Persistence\Settings\ISettingsConfigItem;
use Shevsky\Discount4Review\Persistence\Settings\ISettingsConfigIterator;
use Shevsky\Discount4Review\Util\CommonUtil;
use Shevsky\Discount4Review\Util\IncludeUtil;

/**
 * @property mixed[] $settings_specification = [
 *  $name => [
 *      'default_value' => mixed,
 *      'type' => string
 *  ]
 * ]
 * @property ISettingsConfigItem[] $config_items = [
 *  $name => ISettingsConfigItem
 * ]
 * @property ISettingsConfigIterator $iterator
 */
class SettingsConfig implements ISettingsConfig
{
	private $path;
	private $settings_specification;
	private $config_items;

	/**
	 * @param string $path
	 */
	public function __construct($path)
	{
		$this->path = $path;

		$this->loadSpecification();
		$this->loadConfigPool();
		$this->buildIterator();
	}

	private function loadSpecification()
	{
		$include_util = new IncludeUtil();

		$this->settings_specification = $include_util->includePHPFile($this->path);
	}

	private function loadConfigPool()
	{
		$this->config_items = [];

		foreach ($this->settings_specification as $name => $value)
		{
			$type = gettype($value);
			if ($type === 'array' && CommonUtil::isAssocArray($value))
			{
				$type = 'object';
			}

			$this->config_items[$name] = new SettingsConfigItem($name, $value, $type);
		}
	}

	private function buildIterator()
	{
		$this->iterator = new SettingsConfigIterator(array_values($this->config_items));
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasSetting($name)
	{
		return array_key_exists($name, $this->config_items);
	}

	/**
	 * @param string $name
	 * @return ISettingsConfigItem
	 */
	public function getSetting($name)
	{
		return $this->config_items[$name];
	}

	/**
	 * @return ISettingsConfigIterator
	 */
	public function getIterator()
	{
		return $this->iterator;
	}
}