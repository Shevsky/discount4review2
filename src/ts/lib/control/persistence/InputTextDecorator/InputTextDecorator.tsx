import React, { Component, ReactElement } from 'react';
import InputText, { IInputTextProps } from 'lib/waui/InputText/InputText';
import { WaUISetttings } from 'util/WaUISettings';
import { observer } from 'mobx-react';

export interface IDomainInputTextDecoratorProps extends IInputTextProps {
	name: string;
	arrayAccess?: WaUISetttings.IArrayAccess;
}

export interface IInputTextDecoratorProps extends IDomainInputTextDecoratorProps {
	model: ISettingsModel;
}

@observer
export default class InputTextDecorator extends Component<IInputTextDecoratorProps> {
	render(): ReactElement<InputText> {
		const { name, model, arrayAccess, ...props } = this.props;

		return (
			<InputText
				{...props}
				value={WaUISetttings.Reader(name, model, arrayAccess)}
				params={{ name, model, arrayAccess }}
				onChange={WaUISetttings.Handler}
			/>
		);
	}
}
