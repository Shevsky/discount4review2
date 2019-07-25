<?php

namespace BodySite\SearchPro\Persistence\Settings;

use Iterator;

interface ISettingsConfigIterator extends Iterator
{
	/**
	 * @return ISettingsConfigItem
	 */
	public function current();

	public function next();

	/**
	 * @return string
	 */
	public function key();

	/**
	 * @return bool
	 */
	public function valid();

	public function rewind();
}