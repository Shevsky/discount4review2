import ReactDOM from 'react-dom';
import React from 'react';
import SettingsScreen from 'settings/components/SettingsScreen/SettingsScreen';
import 'settings/model/settings/persistence/ISettingsModel';
import BasicSettingsModel from 'settings/model/settings/domain/BasicSettingsModel';
import StorefrontSettingsModel from 'settings/model/settings/domain/StorefrontSettingsModel';
import ContextData from 'settings/context/ContextData';
import AccessibleSettingsModel from 'settings/model/settings/persistence/AccessibleSettingsModel';

interface ISettingsSettingsProp {
	basic: ISettings;
	storefront: ISettings;
}

export default class Settings {
	private readonly selector: string;
	private readonly params: IGlobalParams;
	private readonly basic_settings: BasicSettingsModel;
	private readonly storefront_settings: StorefrontSettingsModel;
	private readonly context_data: ContextData;

	constructor(selector: string, params: IGlobalParams, settings: ISettingsSettingsProp) {
		this.selector = selector;
		this.params = params;
		this.basic_settings = AccessibleSettingsModel(
			new BasicSettingsModel(settings.basic)
		) as BasicSettingsModel;
		this.storefront_settings = AccessibleSettingsModel(
			new StorefrontSettingsModel(settings.storefront)
		) as StorefrontSettingsModel;
		this.context_data = new ContextData(this.params, this.basic_settings, this.storefront_settings);

		this.init();
	}

	get $element(): HTMLElement {
		return document.querySelector(this.selector);
	}

	init() {
		ReactDOM.render(<SettingsScreen contextData={this.context_data} />, this.$element);
	}
}
