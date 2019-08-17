import React, { ReactElement } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import CheckboxDecorator, {
	IDomainCheckboxDecoratorProps
} from 'lib/control/persistence/CheckboxDecorator/CheckboxDecorator';
import { observer } from 'mobx-react';

@observer
export default class StorefrontCheckbox extends ContextComponent<IDomainCheckboxDecoratorProps> {
	render(): ReactElement<CheckboxDecorator> {
		const { name, ...props } = this.props;

		return <CheckboxDecorator {...props} model={this.storefront_settings} name={name} />;
	}
}
