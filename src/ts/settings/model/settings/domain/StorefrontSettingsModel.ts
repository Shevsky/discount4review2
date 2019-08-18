import CommonSettingsModel from 'settings/model/settings/persistence/CommonSettingsModel';

export default class StorefrontSettingsModel extends CommonSettingsModel {
	'discount.status': boolean;
	'discount.value': number;
	'discount.unit': string;
	'discount.individual_status': boolean;

	'my_order.auto_inject_status': boolean;
}
