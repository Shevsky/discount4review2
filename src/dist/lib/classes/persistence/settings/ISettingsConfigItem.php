<?php

namespace Shevsky\Discount4Review\Persistence\Settings;

interface ISettingsConfigItem
{
	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return mixed
	 */
	public function getDefaultValue();

	/**
	 * @return string
	 */
	public function getType();
}