type TSettingsItemValue<T = any> = T;

type ISettings = {
	[name: string]: ISettingsItem;
};

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

interface IGlobalParams {
	plugin_url: string;
	storefronts: IStorefront[];
	themes: ITheme[];
}