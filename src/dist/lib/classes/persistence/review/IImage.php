<?php

namespace Discount4Review\Persistence\Review;

interface IImage
{
	/**
	 * @return int
	 */
	public function getId();

	/**
	 * @return string
	 */
	public function getUrl();

	/**
	 * @return string
	 */
	public function getFileName();
}