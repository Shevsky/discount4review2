<?php

return array(
	'name' => 'Скидки и бонусы за отзыв',
	'version' => '2.0.0',
	'vendor' => '1015472',
	'frontend' => true,
	'custom_settings' => true,
	'handlers' => array(
		'frontend_my_order' => 'frontendMyOrderHandler',
		'frontend_product' => 'frontendProductHandler',
		'frontend_review_add.before' => 'frontendReviewAddBeforeHandler'
	)
);