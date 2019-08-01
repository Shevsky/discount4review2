<?php
return array(
	'shop_discount4review_basic_settings' => array(
		'id' => array('varchar', 1, 'null' => 0, 'default' => '*'),
		'name' => array('varchar', 50, 'null' => 0),
		'value' => array('text'),
		':keys' => array(
			'PRIMARY' => array('name', 'id'),
		),
	),
	'shop_discount4review_review' => array(
		'id' => array('int', 11, 'null' => 0),
		'sku_id' => array('int', 11),
		'order_item_id' => array('int', 11),
		':keys' => array(
			'PRIMARY' => array('id'),
		),
	),
	'shop_discount4review_storefront_settings' => array(
		'id' => array('varchar', 255, 'null' => 0),
		'name' => array('varchar', 50, 'null' => 0),
		'value' => array('text'),
		':keys' => array(
			'PRIMARY' => array('id', 'name'),
		),
	),
);