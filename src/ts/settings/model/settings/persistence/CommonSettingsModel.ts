import './ISettingsModel';
import { observable } from 'util/mobx';

export default class CommonSettingsModel implements ISettingsModel {
	@observable
	id: string = '*';

	@observable
	data: ISettings = {};

	constructor(settings: ISettings) {
		this.data = settings;
	}

	has(name: string): boolean {
		return this.data.hasOwnProperty(name);
	}

	read(name: string, id: string): any {
		if (!this.has(name)) {
			return undefined;
		}

		const item = this.data[name];
		if (id in item) {
			return item[id];
		}

		return item['*'];
	}

	write(name: string, id: string, value: any): void {
		if (!this.has(name)) {
			return;
		}

		this.data[name][id] = value;
	}
}
