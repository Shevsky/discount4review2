import React, { Component, ReactElement } from 'react';
import Select, { ISelectOption, ISelectProps } from 'lib/waui/Select/Select';
import WaUISettingsHandler from 'util/WaUISettingsHandler';
import { observer } from 'mobx-react';

export interface IDomainSelectDecoratorProps extends ISelectProps {
	name: string;
	options: ISelectOption[];
}

export interface ISelectDecoratorProps extends IDomainSelectDecoratorProps {
	model: ISettingsModel;
}

@observer
export default class SelectDecorator extends Component<ISelectDecoratorProps> {
	render(): ReactElement<Select> {
		const { name, model, options, ...props } = this.props;

		return (
			<Select
				{...props}
				value={model.read(name, model.id)}
				options={options}
				params={{ name, model }}
				onChange={WaUISettingsHandler}
			/>
		);
	}
}
