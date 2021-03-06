<?php

use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Persistence\Access\ICurrency;
use Shevsky\Discount4Review\Persistence\Access\IStorefront;
use Shevsky\Discount4Review\Persistence\Access\ITheme;
use Shevsky\Discount4Review\Persistence\Access\IUserGroup;
use Shevsky\Discount4Review\Persistence\Order\IOrderAction;
use Shevsky\Discount4Review\Persistence\Order\IOrderState;
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

		$plugin_id = shopDiscount4reviewPlugin::PLUGIN_ID;
		$params['plugin_url'] = Context::getPluginUrl();
		$params['save_settings_url'] = "?plugin={$plugin_id}&module=settings&action=save";
		$params['storefronts'] = array_map(
			[__CLASS__, 'storefrontToArray'],
			$this->context->getEnv()->getStorefronts()
		);
		$params['themes'] = array_map(
			[__CLASS__, 'themeToArray'],
			$this->context->getEnv()->getThemes()
		);
		try
		{
			$params['currencies'] = array_map(
				[__CLASS__, 'currencyToArray'],
				$this->context->getEnv()->getCurrencies()
			);
		}
		catch (Exception $e)
		{
			$params['currencies'] = [];
		}
		$params['user_groups'] = array_map(
			[__CLASS__, 'userGroupToArray'],
			$this->context->getEnv()->getUserGroups()
		);
		$params['states'] = array_map(
			[__CLASS__, 'stateToArray'],
			$this->context->getWorkflowRegistry()->getStates()
		);
		$params['actions'] = array_map(
			[__CLASS__, 'actionToArray'],
			$this->context->getWorkflowRegistry()->getActions()
		);

		$params['is_review_images_allowed'] = $this->context->getSystemEnv()->isReviewImagesAllowed();

		$params['integration_availability'] = [
			'shop_coupons' => $this->context->getIntegrationPool()->isAvailableIntegration('shop_coupons'),
			'shop_affiliate' => $this->context->getIntegrationPool()->isAvailableIntegration('shop_affiliate'),
			'flexdiscount' => $this->context->getIntegrationPool()->isAvailableIntegration('flexdiscount'),
		];

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
	 * @param ICurrency $currency
	 * @return mixed[]
	 * @throws Exception
	 */
	private function currencyToArray(ICurrency $currency)
	{
		$currency_array = $currency->toArray();
		$currency_array['current'] = $this->context->getEnv()->getCurrentCurrency() === $currency;

		return $currency_array;
	}

	/**
	 * @param IUserGroup $user_group
	 * @return mixed[]
	 */
	private function userGroupToArray(IUserGroup $user_group)
	{
		return $user_group->toArray();
	}

	/**
	 * @param IOrderState $state
	 * @return mixed[]
	 */
	private function stateToArray(IOrderState $state)
	{
		return $state->toArray();
	}

	/**
	 * @param IOrderAction $action
	 * @return mixed[]
	 */
	private function actionToArray(IOrderAction $action)
	{
		return $action->toArray();
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