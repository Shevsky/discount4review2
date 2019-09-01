import React, { ReactNode } from 'react';
import Styles from './SettingsModelIdSelect.sass';
import ClassNames from 'classnames';
import Select, { ISelectOption } from 'lib/waui/Select/Select';
import ContextComponent from 'settings/context/ContextComponent';
import Field from 'lib/waui/Field/Field';
import { observer } from 'mobx-react';
import Link from 'lib/waui/Link/Link';

interface ISettingsModelIdSelect {
	model: ISettingsModel;
	className?: string;
	fieldWrapped?: boolean;
	[name: string]: any;
}

@observer
export default class SettingsModelIdSelect extends ContextComponent<ISettingsModelIdSelect> {
	render(): ReactNode {
		const { model, fieldWrapped = true, className = '', ...props } = this.props;

		const settingsModelIdSelectClass = ClassNames(Styles.settingsModelIdSelect, {
			[className]: !!className
		});
		const linkClass = ClassNames(Styles.settingsModelIdSelect__link);

		const renderedSelect = (
			<Select
				{...props}
				className={settingsModelIdSelectClass}
				options={this.options}
				value={this.model.id}
				onChange={this.handleChange}
			/>
		);

		if (fieldWrapped) {
			return (
				<Field label={this.label} hint={this.hint} appendTop>
					{renderedSelect}

					{!this.is_general && this.has_differences && (
						<>
							<Link onClick={this.handleClickReset} className={linkClass}>
								Сбросить настройки до общих
							</Link>
						</>
					)}
				</Field>
			);
		} else {
			return renderedSelect;
		}
	}

	get is_general(): boolean {
		return this.model.id === '*';
	}

	get has_differences(): boolean {
		return this.model.hasDifferences('*', this.model.id);
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
		if (this.is_general) {
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
		if (this.is_general) {
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
		return this.model === this.storefront_settings ? this.storefront_options : this.theme_options;
	}

	private get storefront_options(): ISelectOption[] {
		return [
			{
				value: '*',
				label: 'Общие настройки (для всех витрин)'
			},
			...this.params.storefronts.map(storefront => ({
				value: storefront.id,
				label: `${this.model.hasDifferences('*', storefront.id) ? '* ' : ''}${storefront.id}`
			}))
		];
	}

	private get theme_options(): ISelectOption[] {
		return []; // TODO
	}

	private handleChange = (id: string) => {
		this.model.id = id;
	};

	private handleClickReset = (): boolean => {
		this.model.resetModifies(this.model.id);

		return true;
	};
}
