export interface IWaUiParams {
	name: string;
	model: ISettingsModel;
}

const WaUISettingsHandler = (value: any, params: IWaUiParams) => {
	const { name, model } = params;

	model.write(name, model.id, value);
};

export default WaUISettingsHandler;
