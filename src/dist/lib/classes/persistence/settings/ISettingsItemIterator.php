<?php

namespace BodySite\SearchPro\Persistence\Settings;

use \Iterator;

interface ISettingsItemIterator extends Iterator
{
	/**
	 * @return mixed
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