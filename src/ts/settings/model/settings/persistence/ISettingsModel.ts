type TSettingsModelSubscribeHandler = (name: string, id: string, prevValue: any) => void;

interface ISettingsModel {
	id: string;

	data: ISettings;

	has(name: string): boolean;

	read(name: string, id: string): any;

	write(name: string, id: string, value: any): void;

	subscribe(handler: TSettingsModelSubscribeHandler): void;
}
