<?php

namespace Shevsky\Discount4Review\Domain\Common\SettingsItem;

use Shevsky\Discount4Review\Persistence\Settings\ISettingsItem;
use Shevsky\Discount4Review\Persistence\Settings\ISettingsItemIterator;
use Shevsky\Discount4Review\Util\SettingTransformerUtil;

class SettingsItem implements ISettingsItem
{
	private $name;
	private $values = [];
	private $type;

	/**
	 * @param string $name
	 * @param mixed[] $values = [
	 *  '*' => mixed,
	 *  $id => mixed
	 * ]
	 * @param string $type
	 */
	public function __construct($name, array $values, $type)
	{
		$this->name = $name;
		$this->values = $values;
		$this->type = $type;
	}

	/**
	 * @return mixed
	 */
	public function getGeneral()
	{
		return $this->getSpecific('*');
	}

	/**
	 * @param string $id
	 * @return mixed
	 */
	public function getSpecific($id)
	{
		if (!isset($this->values[$id]))
		{
			return null;
		}

		return SettingTransformerUtil::transform($this->values[$id], $this->type);
	}

	/**
	 * @param mixed $value
	 */
	public function setGeneral($value)
	{
		$this->setSpecific('*', $value);
	}

	/**
	 * @param string $id
	 * @param mixed $value
	 */
	public function setSpecific($id, $value)
	{
		$this->values[$id] = $value;
	}

	/**
	 * @return ISettingsItemIterator
	 */
	public function getIterator()
	{
		return new SettingsItemIterator($this->values);
	}

	/**
	 * @return mixed[] = [
	 *  '*' => mixed,
	 *  $id => mixed
	 * ]
	 */
	public function toArray()
	{
		return array_map(
			[__CLASS__, 'transformSettingValue'],
			$this->values
		);
	}

	/**
	 * @param mixed $value
	 * @return mixed
	 */
	private function transformSettingValue($value)
	{
		return SettingTransformerUtil::transform($value, $this->type);
	}
}