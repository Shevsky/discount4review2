<?php

namespace Shevsky\Discount4Review\Domain\Wa\Registry;

use Exception;
use Shevsky\Discount4Review\Persistence\Access\IUserGroup;
use Shevsky\Discount4Review\Persistence\IFactory;
use waContactCategoryModel;

class UserGroupRegistry
{
	private $factory;
	private $contact_category_model;
	private $registry = [];

	/**
	 * @param IFactory $factory
	 */
	public function __construct(IFactory $factory)
	{
		$this->factory = $factory;
		$this->contact_category_model = new waContactCategoryModel();
	}

	/**
	 * @param int $id
	 * @return IUserGroup
	 * @throws Exception
	 */
	public function getById($id)
	{
		if (!isset($this->registry[$id]))
		{
			$this->registry[$id] = $this->buildById($id);
		}

		return $this->registry[$id];
	}

	/**
	 * @param mixed[] $data
	 * @return IUserGroup
	 * @throws Exception
	 */
	public function getByData(array $data)
	{
		if (!array_key_exists('id', $data))
		{
			throw new Exception('Отсутствует параметр "id" для построения экземпляра группы пользователя');
		}

		$id = $data['id'];

		if (!isset($this->registry[$id]))
		{
			$this->registry[$id] = $this->buildByDirtyData($data);
		}

		return $this->registry[$id];
	}

	/**
	 * @param int $id
	 * @return IUserGroup
	 * @throws Exception
	 */
	private function buildById($id)
	{
		return $this->buildByDirtyData([
			'id' => $id
		]);
	}

	/**
	 * @param mixed[] $data
	 * @return IUserGroup
	 * @throws Exception
	 */
	private function buildByDirtyData(array $data)
	{
		if (!array_key_exists('id', $data))
		{
			throw new Exception('Отсутствует параметр "id" для построения экземпляра группы пользователей');
		}

		$data = array_merge($this->contact_category_model->getById($data['id']), $data);

		return $this->buildByData($data);
	}

	/**
	 * @param mixed[] $data
	 * @return IUserGroup
	 */
	private function buildByData(array $data)
	{
		return $this->factory->createUserGroup($data);
	}
}