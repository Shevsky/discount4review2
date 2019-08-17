<?php

use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Persistence\Access\IStorefront;
use Shevsky\Discount4Review\Persistence\Access\ITheme;
use Shevsky\Discount4Review\Persistence\Settings\ISettingsItem;

class shopDiscount4reviewPluginSettingsAction extends waViewAction
{
	private $plugin;
	private $context;
	private $basic_settings;
	private $storefront_settings;

	/**
	 * @param mixed $params
	 */
	public function __construct($params = null)
	{
		parent::__construct($params);

		$this->plugin = shopDiscount4reviewPlugin::getInstance();
		$this->context = Context::getInstance();

		$this->basic_settings = $this->settingsToArray($this->context->getBasicSettingsStorage()->getSettings());
		$this->storefront_settings = $this->settingsToArray(
			$this->context->getStorefrontSettingsStorage()->getSettings()
		);
	}

	public function execute()
	{
		$this->assignVars();
		$this->assignAssets();
	}

	private function assignSettingsVar()
	{
		$settings = [
			'basic' => $this->basic_settings,
			'storefront' => $this->storefront_settings,
		];

		$this->view->assign('settings', $settings);
	}

	private function assignParamsVar()
	{
		$params = [];

		$params['plugin_url'] = Context::getPluginUrl();
		$params['storefronts'] = array_map(
			[__CLASS__, 'storefrontToArray'],
			$this->context->getEnv()->getStorefronts()
		);
		$params['themes'] = array_map(
			[__CLASS__, 'themeToArray'],
			$this->context->getEnv()->getThemes()
		);

		$this->view->assign('params', $params);
	}

	private function assignVars()
	{
		$this->assignSettingsVar();
		$this->assignParamsVar();
	}

	private function assignAssets()
	{
		$js_url = Context::getPluginUrl() . 'js/settings.js';
		$css_url = Context::getPluginUrl() . 'css/settings.css';
		$this->view->assign('js_url', $js_url);
		$this->view->assign('css_url', $css_url);
	}

	/**
	 * @param IStorefront $storefront
	 * @return mixed[]
	 */
	private function storefrontToArray(IStorefront $storefront)
	{
		return $storefront->toArray();
	}

	/**
	 * @param ITheme $theme
	 * @return mixed[]
	 */
	private function themeToArray(ITheme $theme)
	{
		return $theme->toArray(['path']);
	}

	/**
	 * @param ISettingsItem[] $setting_items
	 * @return mixed[] = [
	 *  $setting => [
	 *      '*' => mixed,
	 *      $id => mixed
	 *  ]
	 * ]
	 */
	private function settingsToArray(array $setting_items)
	{
		return array_map(
			[__CLASS__, 'settingsItemToArray'],
			$setting_items
		);
	}

	/**
	 * @param ISettingsItem $settings_item
	 * @return mixed[]
	 */
	private function settingsItemToArray(ISettingsItem $settings_item)
	{
		return $settings_item->toArray();
	}
}