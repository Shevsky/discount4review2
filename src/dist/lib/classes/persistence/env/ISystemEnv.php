<?php

namespace Shevsky\Discount4Review\Persistence\Env;

interface ISystemEnv
{
	/**
	 * @return boolean
	 */
	public function isReviewImagesAllowed();
}