import React, { Component, ReactElement } from 'react';
import Checkbox, { ICheckboxProps } from 'lib/waui/Checkbox/Checkbox';
import { WaUISetttings } from 'util/WaUISettings';
import { observer } from 'mobx-react';

export interface IDomainCheckboxDecoratorProps extends ICheckboxProps {
	name: string;
	arrayAccess?: WaUISetttings.IArrayAccess;
}

export interface ICheckboxDecoratorProps extends IDomainCheckboxDecoratorProps {
	model: ISettingsModel;
}

@observer
export default class CheckboxDecorator extends Component<ICheckboxDecoratorProps> {
	render(): ReactElement<Checkbox> {
		const { name, model, arrayAccess, ...props } = this.props;

		return (
			<Checkbox
				{...props}
				checked={WaUISetttings.Reader(name, model, arrayAccess)}
				params={{ name, model, arrayAccess }}
				onChange={WaUISetttings.Handler}
			/>
		);
	}
}
