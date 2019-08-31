import './ISettingsModel';
import { action, computed, observable, toJS } from 'util/mobx';
import VarClone from 'util/VarClone';
import IsEqual from 'util/IsEqual';

export default class CommonSettingsModel implements ISettingsModel {
	@observable
	id: string = '*';

	@observable
	data: ISettings = {};

	protected subscribes: TSettingsModelSubscribeHandler[] = [];

	is_freezed: boolean = false;

	@observable
	modified_flags: string[] = [];

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

	@action
	write(name: string, id: string, value: any): void {
		if (!this.has(name)) {
			return;
		}

		if (this.is_freezed) {
			return;
		}

		const prevValue = VarClone(this.read(name, id));
		if (!IsEqual(prevValue, value)) {
			this.dispatch(name, id, prevValue);
			this.setModified(id);
		}

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

	hasModifies(id: string): boolean {
		return this.modified_flags.includes(id);
	}

	hasAnyModifies(): boolean {
		return this.modified_flags.length > 0;
	}

	@action
	resetModifiedFlags(id: string): void {
		this.modified_flags = this.modified_flags.filter(_id => _id !== id);
	}

	@action
	resetAllModifiedFlags(): void {
		this.modified_flags = [];
	}

	@action
	resetModifies(id: string): void {
		this.resetModifiedFlags(id);
		this.resetValues(id);
	}

	@action
	resetAllModifies(): void {
		this.modified_flags.forEach(id => {
			this.resetValues(id);
		});
		this.resetAllModifiedFlags();
	}

	protected resetValues(id: string) {
		Object.keys(this.data).forEach(name => {
			this.dispatch(name, id, null);
			delete this.data[name][id];
		});
	}

	protected setModified(id: string) {
		if (!this.modified_flags.includes(id)) {
			this.modified_flags.push(id);
		}
	}

	protected dispatch(name: string, id: string, prevValue: any): void {
		this.subscribes.forEach(handler => handler(name, id, prevValue));
	}
}
