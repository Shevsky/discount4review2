<?php

namespace Shevsky\Discount4Review\Domain\Wa\AssetPersistence;

use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Persistence\Asset\IAsset;
use shopDiscount4reviewPlugin;

abstract class Asset implements IAsset
{
	private $version = '';

	public function __construct()
	{
		$this->setVersion(Context::getPluginVersion());
	}

	/**
	 * @return string
	 */
	public function getAppId()
	{
		return shopDiscount4reviewPlugin::APP_ID;
	}

	/**
	 * @return string
	 */
	public function getPluginId()
	{
		return shopDiscount4reviewPlugin::PLUGIN_ID;
	}

	/**
	 * @return string
	 */
	public function getVersion()
	{
		return $this->version;
	}

	/**
	 * @param string $version
	 */
	public function setVersion($version)
	{
		$this->version = $version;
	}

	/**
	 * @return string
	 */
	public function getResponsePath()
	{
		if ($this->isAbsolute())
		{
			$postfix = '';
			if (!$this->isCache())
			{
				$postfix .= '?' . $this->getVersion();
			}

			return $this->getUrl() . $postfix;
		}

		$postfix = '';
		if ($this->isCache())
		{
			$postfix = '?';
		}

		return "plugins/{$this->getPluginId()}/{$this->getUrl()}{$postfix}";
	}

	/**
	 * @return string
	 */
	public function getFullUrl()
	{
		if ($this->isAbsolute())
		{
			return $this->getResponsePath();
		}

		$postfix = "?{$this->getVersion()}";

		return Context::getPluginUrl() . "{$this->getUrl()}{$postfix}";
	}

	/**
	 * @return bool
	 */
	public function isAbsolute()
	{
		return false;
	}

	/**
	 * @return string
	 */
	public function isCache()
	{
		return true;
	}

	/**
	 * @return string
	 */
	abstract public function getUrl();

	/**
	 * @return string
	 */
	abstract public function getExtension();
}