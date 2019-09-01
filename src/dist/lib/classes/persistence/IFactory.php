<?php

namespace Shevsky\Discount4Review\Persistence;

use Shevsky\Discount4Review\Persistence\Access\ICurrency;
use Shevsky\Discount4Review\Persistence\Access\IUserGroup;
use Shevsky\Discount4Review\Persistence\Order\IOrder;
use Shevsky\Discount4Review\Persistence\Order\IOrderAction;
use Shevsky\Discount4Review\Persistence\Order\IOrderItem;
use Shevsky\Discount4Review\Persistence\Order\IOrderState;
use Shevsky\Discount4Review\Persistence\Product\IProduct;
use Shevsky\Discount4Review\Persistence\Product\ISku;
use Shevsky\Discount4Review\Persistence\Review\IReview;

interface IFactory
{
	/**
	 * @param mixed $data
	 * @return IProduct
	 */
	public function createProduct($data);

	/**
	 * @param IProduct $product
	 * @param mixed $data
	 * @return ISku
	 */
	public function createSku(IProduct $product, $data);

	/**
	 * @param mixed $data
	 * @return IReview
	 */
	public function createReview($data);

	/**
	 * @param mixed $data
	 * @return IOrder
	 */
	public function createOrder($data);

	/**
	 * @param mixed $data
	 * @return IOrderItem
	 */
	public function createOrderItem($data);

	/**
	 * @param mixed $data
	 * @return IOrderState
	 */
	public function createOrderState($data);

	/**
	 * @param mixed $data
	 * @return IOrderAction
	 */
	public function createOrderAction($data);

	/**
	 * @param mixed $data
	 * @return ICurrency
	 */
	public function createCurrency($data);

	/**
	 * @param mixed $data
	 * @return IUserGroup
	 */
	public function createUserGroup($data);
}