import React, { Component, ReactNode } from 'react';
import Styles from './SettingsScreen.sass';
import ClassNames from 'classnames';
import Context from 'settings/context/Context';
import ContextData from 'settings/context/ContextData';

interface ISettingsScreenProps {
	contextData: ContextData;
}

export default class SettingsScreen extends Component<ISettingsScreenProps> {
	get context_data(): ContextData {
		return this.props.contextData;
	}

	render(): ReactNode {
		const settingsScreenClass = ClassNames(Styles.settingsScreen);

		return (
			<div className={settingsScreenClass}>
				<Context.Provider value={this.context_data}>...</Context.Provider>
			</div>
		);
	}
}
