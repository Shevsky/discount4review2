import React, { ReactElement } from 'react';
import Select, { ISelectOption } from 'lib/waui/Select/Select';
import ContextComponent from 'settings/context/ContextComponent';

interface ISettingsModelIdSelect {
	model: ISettingsModel;
	className?: string;
	[name: string]: any;
}

export default class SettingsModelIdSelect extends ContextComponent<ISettingsModelIdSelect> {
	render(): ReactElement<Select> {
		const { model, ...props } = this.props;
		return (
			<Select
				{...props}
				options={this.options}
				value={this.model.id}
				onChange={this.handleChange}
			/>
		);
	}

	private get model(): ISettingsModel {
		return this.props.model;
	}

	private get options(): ISelectOption[] {
		return [
			{
				value: '*',
				label: 'Общие настройки (для всех витрин)'
			},
			...this.params.storefronts.map(storefront => ({
				value: storefront.id,
				label: storefront.id
			}))
		];
	}

	private handleChange = (id: string) => {
		this.model.id = id;
	};
}
