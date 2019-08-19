import React, { Component, ReactElement } from 'react';
import Select, { ISelectOption, ISelectProps } from 'lib/waui/Select/Select';
import { WaUISetttings } from 'util/WaUISettings';
import { observer } from 'mobx-react';

export interface IDomainSelectDecoratorProps extends ISelectProps {
	name: string;
	options: ISelectOption[];
	arrayAccess?: WaUISetttings.IArrayAccess;
}

export interface ISelectDecoratorProps extends IDomainSelectDecoratorProps {
	model: ISettingsModel;
}

@observer
export default class SelectDecorator extends Component<ISelectDecoratorProps> {
	render(): ReactElement<Select> {
		const { name, model, options, arrayAccess, ...props } = this.props;

		return (
			<Select
				{...props}
				value={WaUISetttings.Reader(name, model, arrayAccess)}
				options={options}
				params={{ name, model, arrayAccess }}
				onChange={WaUISetttings.Handler}
			/>
		);
	}
}
