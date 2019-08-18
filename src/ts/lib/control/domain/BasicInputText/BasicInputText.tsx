import React, { ReactElement } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import InputTextDecorator, {
	IDomainInputTextDecoratorProps
} from 'lib/control/persistence/InputTextDecorator/InputTextDecorator';
import { observer } from 'mobx-react';

@observer
export default class BasicInputText extends ContextComponent<IDomainInputTextDecoratorProps> {
	render(): ReactElement<InputTextDecorator> {
		const { name, ...props } = this.props;

		return <InputTextDecorator {...props} model={this.basic_settings} name={name} />;
	}
}
