import './ISettingsModel';
import { observable, toJS } from 'util/mobx';
import VarClone from 'util/VarClone';

export default class CommonSettingsModel implements ISettingsModel {
	@observable
	id: string = '*';

	@observable
	data: ISettings = {};

	protected subscribes: TSettingsModelSubscribeHandler[] = [];

	is_freezed: boolean = false;

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

		if (this.is_freezed) {
			return;
		}

		const prevValue = VarClone(this.read(name, id));
		this.dispatch(name, id, prevValue);

		this.data[name][id] = value;
	}

	subscribe(handler: TSettingsModelSubscribeHandler): void {
		this.subscribes.push(handler);
	}

	freeze(): void {
		this.is_freezed = true;
	}

	unfreeze(): void {
		this.is_freezed = false;
	}

	toJS(): ISettings {
		return toJS(this.data);
	}

	protected dispatch(name: string, id: string, prevValue: any): void {
		this.subscribes.forEach(handler => handler(name, id, prevValue));
	}
}
