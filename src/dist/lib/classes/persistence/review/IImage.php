<?php

namespace Discount4Review\Review;

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