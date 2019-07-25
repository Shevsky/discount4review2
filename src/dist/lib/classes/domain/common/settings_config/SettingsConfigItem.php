<?php

namespace Shevsky\Discount4Review\Domain\Common\SettingsConfig;

use Shevsky\Discount4Review\Persistence\Settings\ISettingsConfigItem;

class SettingsConfigItem implements ISettingsConfigItem
{
	private $name;
	private $default_value;
	private $type;

	/**
	 * @param string $name
	 * @param mixed $default_value
	 * @param string $type
	 */
	public function __construct($name, $default_value, $type)
	{
		$this->name = $name;
		$this->default_value = $default_value;
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getDefaultValue()
	{
		return $this->default_value;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}
}