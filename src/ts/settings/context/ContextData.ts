import { observable } from 'util/mobx';
import BasicSettingsModel from 'settings/model/settings/domain/BasicSettingsModel';
import StorefrontSettingsModel from 'settings/model/settings/domain/StorefrontSettingsModel';

export default class ContextData {
	params: IGlobalParams;
	@observable
	basic_settings: BasicSettingsModel;
	@observable
	storefront_settings: StorefrontSettingsModel;

	constructor(
		params: IGlobalParams,
		basic_settings: BasicSettingsModel,
		storefront_settings: StorefrontSettingsModel
	) {
		this.params = params;
		this.basic_settings = basic_settings;
		this.storefront_settings = storefront_settings;
	}
}
