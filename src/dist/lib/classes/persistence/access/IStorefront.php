<?php

namespace Shevsky\Discount4Review\Persistence\Access;

interface IStorefront
{
	/**
	 * @return string
	 */
	public function getId();

	/**
	 * @return string
	 */
	public function getDomain();

	/**
	 * @return string
	 */
	public function getRoute();

	/**
	 * @return ITheme
	 */
	public function getTheme();

	/**
	 * @param string[] $excluded_rows
	 * @return mixed[] = [
	 *  'id' => string,
	 *  'domain' => string,
	 *  'route' => string,
	 *  'theme' => mixed[]
	 * ]
	 */
	public function toArray(array $excluded_rows = []);
}