import React, { ReactElement, MouseEvent, createRef, RefObject } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import Styles from './SettingsSaver.sass';
import ClassNames from 'classnames';
import BottomFixedBar from 'lib/waui/BottomFixedBar/BottomFixedBar';
import Button from 'lib/waui/Button/Button';
import WaRequest from 'util/WaRequest';
import Icon from 'lib/waui/Icon/Icon';
import { observer } from 'mobx-react';

type TSettingsSaverStatus = 'general' | 'loading' | 'success' | 'error';

interface ISettingsSaverState {
	status: TSettingsSaverStatus;
	message: string;
}

@observer
export default class SettingsSaver extends ContextComponent<{}, ISettingsSaverState> {
	private reset_message_timeout_ms = 2000;
	private reset_message_timeout: number;
	private status_box: RefObject<HTMLDivElement> = createRef<HTMLDivElement>();

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
			[Styles.settingsSaver__statusBox_visible]: this.has_status_box,
			[Styles.settingsSaver__statusBox_error]: this.status === 'error',
			[Styles.settingsSaver__statusBox_success]: this.status === 'success'
		});
		const statusBoxIconClass = ClassNames(Styles.settingsSaver__statusBoxIcon);

		return (
			<BottomFixedBar>
				<div className={settingsSaverClass}>
					<div className={buttonBoxClass}>
						<Button type={this.button_type} onClick={this.handleClickSave}>
							{' '}
							Сохранить{' '}
						</Button>
					</div>
					{this.has_status_box && (
						<div className={statusBoxClass} ref={this.status_box}>
							<Icon
								className={statusBoxIconClass}
								name={this.status === 'success' ? 'yes' : 'no'}
							/>
							{this.message}
						</div>
					)}
				</div>
			</BottomFixedBar>
		);
	}

	get has_modifies(): boolean {
		return this.settings_models.some(settings_model => settings_model.hasAnyModifies());
	}

	get has_status_box(): boolean {
		return ['success', 'error'].includes(this.status);
	}

	get status(): TSettingsSaverStatus {
		return this.state.status;
	}

	set status(status: TSettingsSaverStatus) {
		clearTimeout(this.reset_message_timeout);
		this.setState({ status }, this.handleChangeStatus);
	}

	get message(): string {
		return this.state.message;
	}

	set message(message: string) {
		this.setState({ message });
	}

	get button_type(): string {
		if (this.status === 'loading') {
			return 'loading';
		} else if (this.status === 'error') {
			return 'red';
		}

		if (this.has_modifies) {
			return 'yellow';
		}

		return 'green';
	}

	componentDidMount() {
		this.bindEvents();
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

	protected bindEvents() {
		this.settings_models.forEach(settings_model =>
			settings_model.subscribe(this.handleChangeSettings)
		);
	}

	private freezeSettingsModels() {
		this.settings_models.forEach(settings_model => settings_model.freeze());
	}

	private unfreezeSettingsModels() {
		this.settings_models.forEach(settings_model => settings_model.unfreeze());
	}

	private handleClickSave = (e: MouseEvent<HTMLElement>): boolean => {
		if (!this.has_modifies) {
			return false;
		}

		this.handleBeforeSave();

		this.status = 'loading';

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
				this.settings_models.forEach(settings_model => settings_model.resetAllModifiedFlags());

				this.message = 'Настройки сохранены';
				this.status = 'success';
			})
			.catch(fail => {
				const { message, response } = fail;

				if (message) {
					this.message = message;
				} else {
					this.message = 'Неизвестная ошибка';
					// tslint:disable-next-line
					console.warn(response);
				}

				this.status = 'error';
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

	private handleChangeSettings = () => {
		if (this.has_status_box) {
			this.status = 'general';
		}
	};

	private handleChangeStatus = () => {
		if (this.has_status_box) {
			this.reset_message_timeout = window.setTimeout(() => {
				this.status_box.current.classList.remove(Styles.settingsSaver__statusBox_visible);
			}, this.reset_message_timeout_ms);
		}
	};
}
