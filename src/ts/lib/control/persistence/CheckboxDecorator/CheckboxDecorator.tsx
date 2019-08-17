import React, { Component, ReactElement } from 'react';
import Checkbox, { ICheckboxProps } from 'lib/waui/Checkbox/Checkbox';
import WaUISettingsHandler from 'util/WaUISettingsHandler';
import { observer } from 'mobx-react';

export interface IDomainCheckboxDecoratorProps extends ICheckboxProps {
	name: string;
}

export interface ICheckboxDecoratorProps extends IDomainCheckboxDecoratorProps {
	model: ISettingsModel;
}

@observer
export default class CheckboxDecorator extends Component<ICheckboxDecoratorProps> {
	render(): ReactElement<Checkbox> {
		const { name, model, ...props } = this.props;

		return (
			<Checkbox
				{...props}
				checked={model.read(name, model.id)}
				params={{ name, model }}
				onChange={WaUISettingsHandler}
			/>
		);
	}
}
