<?php

namespace Shevsky\Discount4Review\Domain\Wa\Util;

use Shevsky\Discount4Review\Persistence\Util\IRoutingUtil;
use shopDiscount4reviewPlugin;

class RoutingUtil implements IRoutingUtil
{
	/**
	 * @return string
	 */
	public function getPluginPath()
	{
		$plugin_id = shopDiscount4reviewPlugin::PLUGIN_ID;

		$path = wa(shopDiscount4reviewPlugin::APP_ID)->getAppPath("plugins/{$plugin_id}/");

		return $path;
	}

	/**
	 * @param bool $absolute
	 * @return string
	 */
	public function getPluginUrl($absolute = true)
	{
		$plugin_id = shopDiscount4reviewPlugin::PLUGIN_ID;

		$url = wa(shopDiscount4reviewPlugin::APP_ID)->getAppStaticUrl(shopDiscount4reviewPlugin::APP_ID, $absolute)
			. "plugins/{$plugin_id}/";

		return $url;
	}

	/**
	 * @param string $path
	 * @param bool $absolute
	 * @return string
	 */
	public function getControllerUrl($path, $absolute = true)
	{
		return wa(shopDiscount4reviewPlugin::APP_ID)->getRouteUrl(
			"shop/frontend/{$path}",
			[
				'plugin' => shopDiscount4reviewPlugin::PLUGIN_ID,
			],
			$absolute
		);
	}

	/**
	 * @return string
	 */
	public function getCasePath()
	{
		return $this->getPluginPath() . 'lib/config/data/case/';
	}

	/**
	 * @param bool $public
	 * @return string
	 */
	public function getDataPath($public = true)
	{
		$plugin = shopDiscount4reviewPlugin::PLUGIN_ID;

		return wa(shopDiscount4reviewPlugin::APP_ID)->getDataPath(
			"plugins/{$plugin}/",
			true,
			shopDiscount4reviewPlugin::APP_ID
		);
	}

	/**
	 * @param bool $public
	 * @return string
	 */
	public function getDataUrl($public = true)
	{
		$plugin = shopDiscount4reviewPlugin::PLUGIN_ID;

		return wa(shopDiscount4reviewPlugin::APP_ID)->getDataUrl(
			"plugins/{$plugin}/",
			true,
			shopDiscount4reviewPlugin::APP_ID
		);
	}
}