<?php

namespace Shevsky\Discount4Review\Domain\Common\SettingsConfig;

use Shevsky\Discount4Review\Persistence\Settings\ISettingsConfigItem;
use Shevsky\Discount4Review\Persistence\Settings\ISettingsConfigIterator;

class SettingsConfigIterator implements ISettingsConfigIterator
{
	private $items;
	private $position = 0;

	/**
	 * @param ISettingsConfigItem[] $items
	 */
	public function __construct(array $items)
	{
		$this->items = $items;
	}

	/**
	 * @return ISettingsConfigItem
	 */
	public function current()
	{
		return $this->items[$this->position];
	}

	public function next()
	{
		$this->position++;
	}

	/**
	 * @return string
	 */
	public function key()
	{
		return $this->current()->getName();
	}

	/**
	 * @return bool
	 */
	public function valid()
	{
		return array_key_exists($this->position, $this->items);
	}

	public function rewind()
	{
		$this->position = 0;
	}
}