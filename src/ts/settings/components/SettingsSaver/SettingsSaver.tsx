import React, { ReactElement, MouseEvent } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import Styles from './SettingsSaver.sass';
import ClassNames from 'classnames';
import BottomFixedBar from 'lib/waui/BottomFixedBar/BottomFixedBar';
import Button from 'lib/waui/Button/Button';
import WaRequest from 'util/WaRequest';
import { observer } from 'mobx-react';

type TSettingsSaverStatus = 'general' | 'loading' | 'success' | 'error';

interface ISettingsSaverState {
	status: TSettingsSaverStatus;
	message: string;
}

@observer
export default class SettingsSaver extends ContextComponent<{}, ISettingsSaverState> {
	constructor(props) {
		super(props);

		this.state = {
			status: 'general',
			message: ''
		};
	}

	render(): ReactElement<BottomFixedBar> {
		const settingsSaverClass = ClassNames(Styles.settingsSaver);
		const buttonBoxClass = ClassNames(Styles.settingsSaver__buttonBox);
		const statusBoxClass = ClassNames(Styles.settingsSaver__statusBox, {
			[Styles.settingsSaver__statusBox_visible]: this.status !== 'general'
		});

		return (
			<BottomFixedBar>
				<div className={settingsSaverClass}>
					<div className={buttonBoxClass}>
						<Button type={this.has_modifies ? 'yellow' : 'green'} onClick={this.handleClickSave}>
							Сохранить
						</Button>
					</div>
					<div className={statusBoxClass}>{this.message}</div>
				</div>
			</BottomFixedBar>
		);
	}

	get has_modifies(): boolean {
		return this.settings_models.some(settings_model => settings_model.hasAnyModifies());
	}

	get status(): TSettingsSaverStatus {
		return this.state.status;
	}

	set status(status: TSettingsSaverStatus) {
		this.setState({ status });
	}

	get message(): string {
		return this.state.message;
	}

	set message(message: string) {
		this.setState({ message });
	}

	protected get settings_models_identified(): {
		[id: string]: ISettingsModel;
	} {
		return {
			basic: this.basic_settings,
			storefront: this.storefront_settings
		};
	}

	protected get settings_models(): ISettingsModel[] {
		return Object.values(this.settings_models_identified);
	}

	private freezeSettingsModels() {
		this.settings_models.forEach(settings_model => settings_model.freeze());
	}

	private unfreezeSettingsModels() {
		this.settings_models.forEach(settings_model => settings_model.unfreeze());
	}

	private handleClickSave = (e: MouseEvent<HTMLElement>): boolean => {
		if (!this.has_modifies) {
			//return false;
		}

		this.handleBeforeSave();
		WaRequest.post<{ test: number }>(
			this.params.save_settings_url,
			Object.assign(
				{},
				...Object.entries(this.settings_models_identified).map(([id, settings_model]) => ({
					[id]: JSON.stringify(settings_model.toJS())
				}))
			)
		)
			.then(data => {
				console.log('ok', data, data.test);
			})
			.catch(fail => {
				console.log(fail);
			})
			.finally(this.handleAfterSave);

		return true;
	};

	private handleBeforeSave = () => {
		this.freezeSettingsModels();
	};

	private handleAfterSave = () => {
		this.unfreezeSettingsModels();
	};
}
