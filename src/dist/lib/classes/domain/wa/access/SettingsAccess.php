<?php

namespace Shevsky\Discount4Review\Domain\Wa\Access;

use Shevsky\Discount4Review\Persistence\Access\ISettingsAccess;
use waModel;

abstract class SettingsAccess extends waModel implements ISettingsAccess
{
	private $settings;

	/**
	 * @return array = [
	 *  $name => [
	 *      $id => mixed
	 *  ]
	 * ]
	 */
	private function getSettings()
	{
		if (!isset($this->settings))
		{
			$this->settings = [];

			$select = $this->select('*')->query();

			foreach ($select as $row)
			{
				/**
				 * @var string[] $row = [
				 *  'id' => string,
				 *  'name' => string,
				 *  'value' => string
				 * ]
				 */

				if (!array_key_exists($row['name'], $this->settings))
				{
					$this->settings[$row['name']] = [];
				}

				$this->settings[$row['name']][$row['id']] = $row['value'];
			}
		}

		return $this->settings;
	}

	/**
	 * @inheritDoc
	 */
	public function readSetting($name)
	{
		$settings = $this->getSettings();
		if (!isset($settings[$name]))
		{
			return [];
		}

		return $settings[$name];
	}

	/**
	 * @inheritDoc
	 */
	public function writeSetting($name, $value)
	{
		$data = [
			'name' => $name,
		];

		foreach ($value as $id => $identified_value)
		{
			$identified_data = $data;
			$identified_data['id'] = $id;
			$identified_data['value'] = $identified_value;

			if ($identified_value === null)
			{
				$this->deleteSetting($name, [$id]);
			}
			else
			{
				$this->insert($data, 1);
			}
		}
	}

	/**
	 * @inheritDoc
	 */
	public function deleteSetting($name, array $ids = [])
	{
		$data = [
			'name' => $name,
		];

		if ($ids !== null)
		{
			$data['id'] = $ids;
		}

		$this->deleteByField($data);
	}
}