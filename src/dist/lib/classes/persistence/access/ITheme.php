<?php

namespace Shevsky\Discount4Review\Persistence\Access;

interface ITheme
{
	/**
	 * @return string
	 */
	public function getId();

	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return string
	 */
	public function getDescription();

	/**
	 * @return string
	 */
	public function getUrl();

	/**
	 * @return string
	 */
	public function getPath();

	/**
	 * @return IStorefront[]
	 */
	public function getStorefronts();

	/**
	 * @return array[] = [
	 *  $file_idx => [
	 *      'path' => string,
	 *      'description' => string,
	 *      'is_modified' => bool,
	 *      'is_customized' => bool
	 *  ]
	 * ]
	 */
	public function getFiles();

	/**
	 * @param string $path
	 * @return string[] = [
	 *  'path' => string,
	 *  'description' => string,
	 *  'is_modified' => bool,
	 *  'is_customized' => bool
	 * ]
	 */
	public function getFile($path);

	/**
	 * @param string $path
	 * @param string $description
	 * @return string
	 */
	public function setFile($path, $description = '');

	/**
	 * @param string $path
	 * @return bool
	 */
	public function hasFile($path);

	/**
	 * @param string $path
	 */
	public function removeFile($path);

	/**
	 * @param string[] $excluded_rows
	 * @return mixed[] = [
	 *  'id' => number,
	 *  'name' => string,
	 *  'description' => string,
	 *  'url' => string,
	 *  'path' => string,
	 *  'storefronts' => array[]
	 * ]
	 */
	public function toArray(array $excluded_rows = []);
}