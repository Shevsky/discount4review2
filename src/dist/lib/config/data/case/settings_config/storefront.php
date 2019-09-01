<?php

return [
	'discount.status' => true,
	'discount.coupon_type' => 'shop_coupons',
	'discount.coupon_length' => '16',
	'discount.coupon_prefix' => 'DSC4RVW',
	'discount.value' => 0,
	'discount.unit' => '%',
	'discount.per_1_value' => 0,
	'discount.per_1_unit' => '%',
	'discount.individual_status' => false,
	'discount.individual_value' => new stdClass(),
	'discount.individual_unit' => new stdClass(),
	'discount.individual_per_1_value' => new stdClass(),
	'discount.individual_per_1_unit' => new stdClass(),
	'discount.image_bonus_value' => 0,
	'discount.image_bonus_unit' => '%',
	'discount.image_bonus_per_1_value' => 0,
	'discount.image_bonus_per_1_unit' => '%',

	'bonus.status' => true,
	'bonus.type' => 'shop_affiliate',
	'bonus.value' => 0,
	'bonus.per_1_value' => 0,
	'bonus.order_percent_value' => 0,
	'bonus.individual_status' => false,
	'bonus.individual_value' => new stdClass(),
	'bonus.individual_per_1_value' => new stdClass(),
	'bonus.individual_order_percent_value' => new stdClass(),
	'bonus.image_bonus_value' => 0,
	'bonus.image_bonus_per_1_value' => 0,

	'orders_availability.from_date' => '2018-01-01',
	'orders_availability.state_ids' => ['completed' => true],
	'orders_availability.is_for_latest' => false,
	'orders_availability.products_min_count' => 1,
	'orders_availability.order_sum_min' => 0,

	'my_order.auto_inject_status' => true
];