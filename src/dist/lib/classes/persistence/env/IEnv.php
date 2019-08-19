<?php

namespace Shevsky\Discount4Review\Persistence\Env;

use Shevsky\Discount4Review\Persistence\Access\ICurrency;
use Shevsky\Discount4Review\Persistence\Access\IStorefront;
use Shevsky\Discount4Review\Persistence\Access\ITheme;
use Shevsky\Discount4Review\Persistence\Access\IUserGroup;

interface IEnv
{
	/**
	 * @return IStorefront[]
	 */
	public function getStorefronts();

	/**
	 * @return IStorefront
	 */
	public function getCurrentStorefront();

	/**
	 * @return ITheme[]
	 */
	public function getThemes();

	/**
	 * @return ITheme
	 */
	public function getCurrentTheme();

	/**
	 * @return ICurrency[]
	 */
	public function getCurrencies();

	/**
	 * @return ICurrency
	 */
	public function getCurrentCurrency();

	/**
	 * @return IUserGroup[]
	 */
	public function getUserGroups();

	/**
	 * @return IUserGroup
	 */
	public function getCurrentUserGroups();
}