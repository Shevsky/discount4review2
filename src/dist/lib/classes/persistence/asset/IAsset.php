<?php

namespace Shevsky\Discount4Review\Persistence\Asset;

interface IAsset
{
	/**
	 * @return string
	 */
	public function getUrl();

	/**
	 * @return string
	 */
	public function getExtension();
}