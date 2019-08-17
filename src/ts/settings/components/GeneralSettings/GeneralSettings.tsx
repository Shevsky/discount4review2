import React, { ReactNode } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import Field from 'lib/waui/Field/Field';
import BasicCheckbox from 'lib/control/domain/BasicCheckbox/BasicCheckbox';
import { observer } from 'mobx-react';

@observer
export default class GeneralSettings extends ContextComponent {
	render(): ReactNode {
		return (
			<div>
				<Field label="Плагин включен">
					<BasicCheckbox name="status" />
				</Field>
			</div>
		);
	}
}
