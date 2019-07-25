<?php

namespace Shevsky\Discount4Review\Persistence\Settings;

interface ISettingsItem
{
	/**
	 * @return mixed
	 */
	public function getGeneral();

	/**
	 * @param string $id
	 * @return mixed
	 */
	public function getSpecific($id);

	/**
	 * @param mixed $value
	 */
	public function setGeneral($value);

	/**
	 * @param string $id
	 * @param mixed $value
	 */
	public function setSpecific($id, $value);

	/**
	 * @return ISettingsItemIterator
	 */
	public function getIterator();

	/**
	 * @return mixed[] = [
	 *  '*' => mixed,
	 *  $id => mixed
	 * ]
	 */
	public function toArray();
}