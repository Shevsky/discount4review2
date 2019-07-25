<?php

namespace Shevsky\Discount4Review\Domain\Common\SettingsItem;

use Shevsky\Discount4Review\Persistence\Settings\ISettingsItemIterator;

class SettingsItemIterator implements ISettingsItemIterator
{
	private $values;
	private $position = 0;

	/**
	 * @param mixed[] $values = [
	 *  '*' => mixed,
	 *  $id => mixed
	 * ]
	 */
	public function __construct(array $values)
	{
		$this->values = [];
		foreach ($values as $id => $value)
		{
			$this->values[] = [
				'id' => $id,
				'value' => $value,
			];
		}
	}

	/**
	 * @return mixed
	 */
	public function current()
	{
		return $this->values[$this->position]['value'];
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
		return $this->values[$this->position]['id'];
	}

	/**
	 * @return bool
	 */
	public function valid()
	{
		return array_key_exists($this->position, $this->values);
	}

	public function rewind()
	{
		$this->position = 0;
	}
}