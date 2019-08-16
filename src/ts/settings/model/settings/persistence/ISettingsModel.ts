interface ISettingsModel {
	id: string;

	data: ISettings;

	has(name: string): boolean;

	read(name: string, id: string): any;

	write(name: string, id: string, value: any): void;
}
