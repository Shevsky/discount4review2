type TSettingsItemValue<T = any> = T;

interface ISettings {
	[name: string]: ISettingsItem;
}

interface ISettingsItem<T = any> {
	'*': TSettingsItemValue<T>;
	[id: string]: TSettingsItemValue<T>;
}

interface IStorefront {
	id: string;
	domain: string;
	route: string;
	theme: ITheme;
}

interface ITheme {
	id: string;
	name: string;
	description: string;
	url: string;
	path: string;
	storefronts: IStorefront[];
}

interface ICurrency {
	code: string;
	sign: string;
	sign_html: string;
	sign_position: number;
	sign_delim: string;
	decimal_point: string;
	frac_digits: number;
	thousands_sep: string;
	current?: boolean;
}

interface IUserGroup {
	id: number;
	name: string;
	params?: {
		system_id: string;
		icon: string;
	};
}

interface IIntegrationAvailability {
	shop_coupons: boolean;
	shop_affiliate: boolean;
	flexdiscount: boolean;
}

interface IGlobalParams {
	plugin_url: string;
	save_settings_url: string;
	storefronts: IStorefront[];
	themes: ITheme[];
	currencies: ICurrency[];
	user_groups: IUserGroup[];
	is_review_images_allowed: boolean;
	integration_availability: IIntegrationAvailability;
}
