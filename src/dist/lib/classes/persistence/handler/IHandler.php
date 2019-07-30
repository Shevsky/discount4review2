<?php

namespace Shevsky\Discount4Review\Persistence\Handler;

interface IHandler
{
	/**
	 * @return mixed
	 */
	public function execute();
}