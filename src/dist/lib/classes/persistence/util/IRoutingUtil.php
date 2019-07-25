<?php

namespace Shevsky\Discount4Review\Persistence\Util;

interface IRoutingUtil
{
	/**
	 * @return string
	 */
	public function getPluginPath();

	/**
	 * @param bool $absolute
	 * @return string
	 */
	public function getPluginUrl($absolute = true);

	/**
	 * @param string $path
	 * @param bool $absolute
	 * @return string
	 */
	public function getControllerUrl($path, $absolute = true);

	/**
	 * @return string
	 */
	public function getCasePath();

	/**
	 * @param bool $public
	 * @return string
	 */
	public function getDataPath($public = true);

	/**
	 * @param bool $public
	 * @return string
	 */
	public function getDataUrl($public = true);
}