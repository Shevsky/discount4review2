import React, { ReactNode } from 'react';
import Select, { ISelectOption } from 'lib/waui/Select/Select';
import ContextComponent from 'settings/context/ContextComponent';
import Field from 'lib/waui/Field/Field';

interface ISettingsModelIdSelect {
	model: ISettingsModel;
	className?: string;
	fieldWrapped?: boolean;
	[name: string]: any;
}

export default class SettingsModelIdSelect extends ContextComponent<ISettingsModelIdSelect> {
	render(): ReactNode {
		const { model, fieldWrapped = true, ...props } = this.props;

		const renderedSelect = (
			<Select
				{...props}
				options={this.options}
				value={this.model.id}
				onChange={this.handleChange}
			/>
		);

		if (fieldWrapped) {
			return (
				<Field label={this.label} hint={this.hint} appendTop>
					{renderedSelect}
				</Field>
			);
		} else {
			return renderedSelect;
		}
	}

	private get model(): ISettingsModel {
		return this.props.model;
	}

	private get label(): string {
		return this.model === this.storefront_settings ? 'Витрина' : 'Тема дизайна';
	}

	private get hint(): ReactNode {
		return this.model === this.storefront_settings ? this.storefront_hint : this.theme_hint;
	}

	private get storefront_hint(): ReactNode {
		if (this.model.id === '*') {
			return 'Настройки ниже будут применены для всех витрин';
		} else {
			return (
				<>
					Настройки ниже будут применены только к витрине <b>{this.model.id}</b>
				</>
			);
		}
	}

	private get theme_hint(): ReactNode {
		if (this.model.id === '*') {
			return 'Настройки и шаблоны ниже будут применены для всех тем дизайна';
		} else {
			return (
				<>
					Настройки и шаблоны ниже будут применены только для темы дизайна <b>{this.model.id}</b>
				</>
			);
		}
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
