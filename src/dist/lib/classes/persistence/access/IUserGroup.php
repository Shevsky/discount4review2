<?php

namespace Shevsky\Discount4Review\Persistence\Access;

interface IUserGroup
{
	/**
	 * @return int
	 */
	public function getId();

	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return mixed[]
	 */
	public function getParams();
}