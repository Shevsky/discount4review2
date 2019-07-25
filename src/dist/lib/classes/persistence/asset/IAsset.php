<?php

namespace BodySite\SearchPro\Persistence\Asset;

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