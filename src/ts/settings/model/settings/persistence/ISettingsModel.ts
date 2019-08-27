type TSettingsModelSubscribeHandler = (name: string, id: string, prevValue: any) => void;

interface ISettingsModel {
	id: string;

	data: ISettings;

	is_freezed: boolean;

	has(name: string): boolean;

	read(name: string, id: string): any;

	write(name: string, id: string, value: any): void;

	subscribe(handler: TSettingsModelSubscribeHandler): void;

	freeze(): void;

	unfreeze(): void;

	toJS(): ISettings;

	hasModifies(id: string): boolean;

	hasAnyModifies(): boolean;

	resetModifies(id: string): void;

	resetAllModifies(): void;
}
