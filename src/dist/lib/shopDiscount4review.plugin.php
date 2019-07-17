<?php

class shopDiscount4reviewPlugin extends shopPlugin
{
	const APP_ID = 'shop';
	const PLUGIN_ID = 'discount4review';

	/**
	 * @inheritDoc
	 */
	public function __construct($info)
	{
		parent::__construct($info);

		$this->registerAutoloader();
	}

	/**
	 * @return self
	 */
	public static function getInstance()
	{
		return wa(self::APP_ID)->getPlugin(self::PLUGIN_ID);
	}

	private function registerAutoloader()
	{
		require_once __DIR__ . '/autoload.php';
	}
}