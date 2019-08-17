import React, { Component, ReactElement } from 'react';
import InputText, { IInputTextProps } from 'lib/waui/InputText/InputText';
import WaUISettingsHandler from 'util/WaUISettingsHandler';
import { observer } from 'mobx-react';

export interface IDomainInputTextDecoratorProps extends IInputTextProps {
	name: string;
}

export interface IInputTextDecoratorProps extends IDomainInputTextDecoratorProps {
	model: ISettingsModel;
}

@observer
export default class InputTextDecorator extends Component<IInputTextDecoratorProps> {
	render(): ReactElement<InputText> {
		const { name, model, ...props } = this.props;

		return (
			<InputText
				{...props}
				value={model.read(name, model.id)}
				params={{ name, model }}
				onChange={WaUISettingsHandler}
			/>
		);
	}
}
