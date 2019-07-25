<?php

namespace Shevsky\Discount4Review\Domain\Common\SettingsStorage;

class BasicSettingsStorage extends CommonSettingsStorage
{
	/**
	 * @return string
	 */
	protected function getCase()
	{
		return 'basic';
	}

	/**
	 * @return bool
	 */
	public function getStatus()
	{
		return $this->getSetting('status')->getGeneral();
	}
}