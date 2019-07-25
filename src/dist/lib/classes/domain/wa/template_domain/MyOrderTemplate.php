<?php

namespace Shevsky\Discount4Review\Domain\Wa\TemplateDomain;

use Shevsky\Discount4Review\Domain\Wa\AssetDomain\MyOrderCSSAsset;
use Shevsky\Discount4Review\Domain\Wa\AssetDomain\MyOrderJSAsset;
use Shevsky\Discount4Review\Domain\Wa\AssetPersistence\CSSAsset;
use Shevsky\Discount4Review\Domain\Wa\AssetPersistence\JSAsset;
use Shevsky\Discount4Review\Domain\Wa\TemplatePersistence\ThemedTemplate;

class MyOrderTemplate extends ThemedTemplate
{
	/**
	 * @return JSAsset[]
	 */
	public function getJS()
	{
		return [
			new MyOrderJSAsset(),
		];
	}

	/**
	 * @return CSSAsset[]
	 */
	public function getCSS()
	{
		return [
			new MyOrderCSSAsset(),
		];
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'my_order';
	}

	/**
	 * @return string
	 */
	public function getExtension()
	{
		return 'html';
	}

	/**
	 * @return string
	 */
	protected function getSourceTemplate()
	{
		return 'frontend/my_order.html';
	}

	/**
	 * @return string
	 */
	protected function getThemeTemplate()
	{
		return 'discount4review_plugin_my_order.html';
	}
}