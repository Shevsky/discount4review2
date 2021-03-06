<?php

namespace Shevsky\Discount4Review\Domain\Wa\Review;

use Shevsky\Discount4Review\Persistence\Review\IAuthor;

class Author implements IAuthor
{
	private $id;
	private $name;
	private $email;
	private $ip;

	/**
	 * @param int $id
	 * @param string $name
	 * @param string $email
	 * @param string $ip
	 */
	public function __construct($id, $name, $email, $ip)
	{
		$this->id = $id;
		$this->name = $name;
		$this->email = $email;
		$this->ip = $ip;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return (int)$this->id;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return string
	 */
	public function getIp()
	{
		return $this->ip;
	}
}