type TSettingsItemValue<T = any> = T;

type ISettings = {
	[name: string]: ISettingsItem;
};

interface ISettingsItem<T = any> {
	'*': TSettingsItemValue<T>;
	[id: string]: TSettingsItemValue<T>;
}

interface IGlobalParams {}
