export namespace WaUISetttings {
	export interface IParams {
		name: string;
		model: ISettingsModel;
		arrayAccess?: IArrayAccess;
	}

	export interface IArrayAccess {
		index: number;
		defaultValue?: string | number;
	}

	export const ArrayAccessPrepare = (name: string, value: any) => {
		if (typeof value !== 'object') {
			throw `Невозможно использование arrayAccess для поля "${name}"`;
		}

		if (Array.isArray(value)) {
			value = {};
		}

		return value;
	};

	export const Reader = (name: string, model: ISettingsModel, arrayAccess?: IArrayAccess) => {
		let value = model.read(name, model.id);

		if (!arrayAccess) {
			return value;
		}

		value = ArrayAccessPrepare(name, value);

		const { index, defaultValue = '' } = arrayAccess;

		if (!value.hasOwnProperty(index)) {
			value[index] = defaultValue;
		}

		return value[index];
	};

	export const Handler = (value: any, params: IParams) => {
		const { name, model, arrayAccess } = params;

		if (arrayAccess) {
			let current_value = model.read(name, model.id);
			current_value = ArrayAccessPrepare(name, current_value);

			const { index } = arrayAccess;

			value = {
				...current_value,
				[index]: value
			};
		}

		model.write(name, model.id, value);
	};
}
