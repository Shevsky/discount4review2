import './ISettingsModel';

const AccessibleSettingsModel = (Model: ISettingsModel): ISettingsModel => {
	return new Proxy(Model, {
		get(target: ISettingsModel, name: string) {
			if (target.has(name)) {
				return target.read(name, target.id);
			}

			return target[name];
		},

		set(target: ISettingsModel, name: string, value: any, receiver: any): boolean {
			if (target.has(name)) {
				target.write(name, target.id, value);
				return true;
			}

			target[name] = value;
			return true;
		}
	});
};

export default AccessibleSettingsModel;
