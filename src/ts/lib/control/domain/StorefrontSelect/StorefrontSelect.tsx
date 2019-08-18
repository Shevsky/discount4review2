import React, { ReactElement } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import SelectDecorator, {
	IDomainSelectDecoratorProps
} from 'lib/control/persistence/SelectDecorator/SelectDecorator';
import { observer } from 'mobx-react';

@observer
export default class StorefrontSelect extends ContextComponent<IDomainSelectDecoratorProps> {
	render(): ReactElement<SelectDecorator> {
		const { name, ...props } = this.props;

		return <SelectDecorator {...props} model={this.storefront_settings} name={name} />;
	}
}
