<?php

namespace Shevsky\Discount4Review\Domain\Wa\Access;

use Shevsky\Discount4Review\Persistence\Access\IUserGroup;

class UserGroup implements IUserGroup
{
	private $data;

	/**
	 * @param mixed[] $data
	 */
	public function __construct(array $data)
	{
		$this->data = $data;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return (int)$this->data['id'];
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->data['name'];
	}

	/**
	 * @return mixed[] = [
	 *  'icon' => string
	 * ]
	 */
	public function getParams()
	{
		return [
			'system_id' => $this->data['system_id'],
			'icon' => $this->data['icon']
		];
	}

	/**
	 * @return mixed[]
	 */
	public function toArray()
	{
		return [
			'id' => $this->getId(),
			'name' => $this->getName(),
			'params' => $this->getParams()
		];
	}
}