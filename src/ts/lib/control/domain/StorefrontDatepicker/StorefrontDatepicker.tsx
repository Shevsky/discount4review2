import React, { ReactElement } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import { observer } from 'mobx-react';
import DatepickerDecorator, {
	IDomainDatepickerDecoratorProps
} from 'lib/control/persistence/DatepickerDecorator/DatepickerDecorator';

@observer
export default class StorefrontDatepicker extends ContextComponent<
	IDomainDatepickerDecoratorProps
> {
	render(): ReactElement<DatepickerDecorator> {
		const { name, ...props } = this.props;

		return <DatepickerDecorator {...props} model={this.storefront_settings} name={name} />;
	}
}
