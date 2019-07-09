<?php

class shopDiscount4ReviewPlugin extends shopPlugin
{
	const APP_ID = 'shop';
	const PLUGIN_ID = 'discount4review';

	/**
	 * @return self
	 */
	public static function getInstance()
	{
		return wa(self::APP_ID)->getPlugin(self::PLUGIN_ID);
	}
}