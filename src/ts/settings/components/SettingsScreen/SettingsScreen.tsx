import React, { Component, ReactNode } from 'react';
import Styles from './SettingsScreen.sass';
import ClassNames from 'classnames';
import Context from 'settings/context/Context';
import ContextData from 'settings/context/ContextData';
import GeneralSettings from 'settings/components/GeneralSettings/GeneralSettings';
import Header from 'lib/waui/Header/Header';
import { observer } from 'mobx-react';
import SpecificSettings from 'settings/components/SpecificSettings/SpecificSettings';
import SettingsSaver from 'settings/components/SettingsSaver/SettingsSaver';

interface ISettingsScreenProps {
	contextData: ContextData;
}

@observer
export default class SettingsScreen extends Component<ISettingsScreenProps> {
	render(): ReactNode {
		const settingsScreenClass = ClassNames(Styles.settingsScreen);

		return (
			<div className={settingsScreenClass}>
				<Header>Скидки и бонусы за отзыв</Header>

				<Context.Provider value={this.context_data}>
					<GeneralSettings />

					<SpecificSettings />

					<SettingsSaver />
				</Context.Provider>
			</div>
		);
	}

	get context_data(): ContextData {
		return this.props.contextData;
	}

	get status(): boolean {
		return this.context_data.basic_settings.status;
	}
}
