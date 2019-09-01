import CommonSettingsModel from 'settings/model/settings/persistence/CommonSettingsModel';

export default class StorefrontSettingsModel extends CommonSettingsModel {
	'discount.status': boolean;
	'discount.coupon_type': boolean;
	'discount.coupon_length': number;
	'discount.coupon_prefix': string;
	'discount.value': number;
	'discount.unit': string;
	'discount.per_1_value': number;
	'discount.per_1_unit': string;
	'discount.individual_status': boolean;
	'discount.individual_value': object;
	'discount.individual_unit': object;
	'discount.individual_per_1_value': object;
	'discount.individual_per_1_unit': object;
	'discount.image_bonus_value': number;
	'discount.image_bonus_unit': string;
	'discount.image_bonus_per_1_value': number;
	'discount.image_bonus_per_1_unit': string;

	'bonus.status': boolean;
	'bonus.type': string;
	'bonus.value': number;
	'per_1_value': number;
	'bonus.order_percent_value': number;
	'bonus.individual_status': boolean;
	'bonus.individual_value': object;
	'bonus.individual_per_1_value': object;
	'bonus.individual_order_percent_value': object;
	'bonus.image_bonus_value': number;
	'bonus.image_bonus_per_1_value': number;

	'my_order.auto_inject_status': boolean;
}
