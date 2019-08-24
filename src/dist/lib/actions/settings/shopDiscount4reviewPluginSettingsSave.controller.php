<?php

use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Persistence\Settings\ISettingsStorage;
use Shevsky\Discount4Review\Service\SettingsSaveService;
use Shevsky\Discount4Review\Util\JsonUtil;

class shopDiscount4reviewPluginSettingsSaveController extends waJsonController
{
	public function execute()
	{
		$basic_settings_json = waRequest::post('basic', '', waRequest::TYPE_STRING);
		$storefront_settings_json = waRequest::post('storefront', '', waRequest::TYPE_STRING);

		try {
			$basic_settings = JsonUtil::decode($basic_settings_json);
			$storefront_settings = JsonUtil::decode($storefront_settings_json);
		} catch (Exception $e) {
			$this->setError($e->getMessage());
			return;
		}

		$basic_settings_storage = Context::getInstance()->getBasicSettingsStorage();
		$storefront_settings_storage = Context::getInstance()->getStorefrontSettingsStorage();

		$this->saveSettings($basic_settings_storage, $basic_settings);
		$this->saveSettings($storefront_settings_storage, $storefront_settings);

		$this->response = [
			'test' => 123
		];
	}

	/**
	 * @param ISettingsStorage $settings_storage
	 * @param mixed[] $settings
	 */
	private function saveSettings(ISettingsStorage $settings_storage, array $settings)
	{
		$settings_save_service = new SettingsSaveService($settings_storage, $settings);
		$settings_save_service->saveSettings();
	}
}