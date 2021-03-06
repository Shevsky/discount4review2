<?php

namespace Shevsky\Discount4Review\Persistence\Review;

interface IAuthor
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
	 * @return string
	 */
	public function getEmail();

	/**
	 * @return string
	 */
	public function getIp();
}