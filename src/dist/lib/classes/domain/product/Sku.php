<?php

namespace Discount4Review\Domain\Product;

use Discount4Review\Persistence\Product\ISku;

class Sku implements ISku
{
	private $id;
	private $sku;

	/**
	 * @param int $id
	 * @param mixed[] $sku = [
	 *  'name' => string,
	 *  'sku' => string,
	 *  'count' => int
	 * ]
	 */
	public function __construct($id, $sku)
	{
		$this->id = $id;
		$this->sku = $sku;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getCode()
	{
		if (isset($this->sku['sku']))
		{
			return $this->sku['sku'];
		}

		return '';
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		if (isset($this->sku['name']))
		{
			return $this->sku['name'];
		}

		return '';
	}
}