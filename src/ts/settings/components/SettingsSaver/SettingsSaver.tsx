import React, { ReactElement, MouseEvent } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import Styles from './SettingsSaver.sass';
import ClassNames from 'classnames';
import BottomFixedBar from 'lib/waui/BottomFixedBar/BottomFixedBar';
import Button from 'lib/waui/Button/Button';
import WaRequest from 'util/WaRequest';

type TSettingsSaverStatus = 'general' | 'loading' | 'success' | 'error';

interface ISettingsSaverState {
	has_modifies: boolean;
	status: TSettingsSaverStatus;
	message: string;
}

export default class SettingsSaver extends ContextComponent<{}, ISettingsSaverState> {
	constructor(props) {
		super(props);

		this.state = {
			has_modifies: false,
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

	componentDidMount(): void {
		this.bindEvents();
	}

	get has_modifies(): boolean {
		return this.state.has_modifies;
	}

	set has_modifies(has_modifies: boolean) {
		this.setState({ has_modifies });
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

	private bindEvents() {
		this.settings_models.forEach(settings_model =>
			settings_model.subscribe(this.handleSettingsChanged)
		);
	}

	private freezeSettingsModels() {
		this.settings_models.forEach(settings_model => settings_model.freeze());
	}

	private unfreezeSettingsModels() {
		this.settings_models.forEach(settings_model => settings_model.unfreeze());
	}

	private handleSettingsChanged = (name: string, id: string, prevValue: any) => {
		this.has_modifies = true;
	};

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
