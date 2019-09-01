import React, { ReactElement } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import { observer } from 'mobx-react';
import DatepickerDecorator, {
	IDomainDatepickerDecoratorProps
} from 'lib/control/persistence/DatepickerDecorator/DatepickerDecorator';

@observer
export default class BasicDatepicker extends ContextComponent<IDomainDatepickerDecoratorProps> {
	render(): ReactElement<DatepickerDecorator> {
		const { name, ...props } = this.props;

		return <DatepickerDecorator {...props} model={this.basic_settings} name={name} />;
	}
}
