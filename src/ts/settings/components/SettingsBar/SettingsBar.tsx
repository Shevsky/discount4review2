import React, { ReactElement, MouseEvent, createRef, RefObject } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import Styles from './SettingsBar.sass';
import ClassNames from 'classnames';
import BottomFixedBar from 'lib/waui/BottomFixedBar/BottomFixedBar';
import Button from 'lib/waui/Button/Button';
import Icon from 'lib/waui/Icon/Icon';
import { observer } from 'mobx-react';
import ContextData from 'settings/context/ContextData';
import { SettingsSave } from 'settings/classes/services/SettingsSave';

interface ISettingsBarState {
	status: SettingsSave.TStatus;
	message: string;
}

@observer
export default class SettingsBar extends ContextComponent<{}, ISettingsBarState> {
	readonly state: ISettingsBarState = {
		status: 'waiting',
		message: ''
	};

	private reset_message_timeout_ms = 2000;
	private reset_message_timeout: number;
	private status_box: RefObject<HTMLDivElement> = createRef<HTMLDivElement>();

	private readonly save_service: SettingsSave.Service;
	private readonly models: SettingsSave.IModels;

	constructor(props, context: ContextData) {
		super(props, context);

		this.models = {
			basic: this.basic_settings,
			storefront: this.storefront_settings
		};

		this.save_service = new SettingsSave.Service(this.models, this.params.save_settings_url);

		this.bindEvents();
		this.bindDispatchers();
	}

	render(): ReactElement<BottomFixedBar> {
		const settingsBarClass = ClassNames(Styles.settingsBar);
		const buttonBoxClass = ClassNames(Styles.settingsBar__buttonBox);
		const statusBoxClass = ClassNames(Styles.settingsBar__statusBox, {
			[Styles.settingsBar__statusBox_visible]: this.has_status_box,
			[Styles.settingsBar__statusBox_error]: this.status === 'error',
			[Styles.settingsBar__statusBox_success]: this.status === 'done'
		});
		const statusBoxIconClass = ClassNames(Styles.settingsBar__statusBoxIcon);

		return (
			<BottomFixedBar>
				<div className={settingsBarClass}>
					<div className={buttonBoxClass}>
						<Button type={this.button_type} onClick={this.handleClickSave}>
							{' '}
							Сохранить{' '}
						</Button>
					</div>
					{this.has_status_box && (
						<div className={statusBoxClass} ref={this.status_box}>
							<Icon className={statusBoxIconClass} name={this.status === 'done' ? 'yes' : 'no'} />
							{this.message}
						</div>
					)}
				</div>
			</BottomFixedBar>
		);
	}

	protected get models_array(): ISettingsModel[] {
		return Object.values(this.models);
	}

	protected get has_modifies(): boolean {
		return this.models_array.some(model => model.hasAnyModifies());
	}

	protected get has_status_box(): boolean {
		return ['done', 'error'].includes(this.status);
	}

	protected get status(): SettingsSave.TStatus {
		return this.state.status;
	}

	protected set status(status: SettingsSave.TStatus) {
		clearTimeout(this.reset_message_timeout);
		this.setState({ status }, this.handleChangeStatus);
	}

	protected get message(): string {
		return this.state.message;
	}

	protected set message(message: string) {
		this.setState({ message });
	}

	protected get button_type(): string {
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

	private bindEvents() {
		this.models_array.forEach(model => model.subscribe(this.handleChangeSettings));
	}

	private bindDispatchers() {
		this.save_service.subscribe(
			(status, message?: string) => {
				this.status = status;

				if (message) {
					this.message = message;
				}
			},
			'done',
			'loading',
			'waiting',
			'error'
		);
	}

	private handleClickSave = (e: MouseEvent<HTMLElement>): boolean => {
		this.save_service.execute();

		return true;
	};

	private handleChangeSettings = () => {
		if (this.has_status_box) {
			this.status = 'waiting';
		}
	};

	private handleChangeStatus = () => {
		if (this.has_status_box) {
			this.reset_message_timeout = window.setTimeout(() => {
				this.status_box.current.classList.remove(Styles.settingsBar__statusBox_visible);
			}, this.reset_message_timeout_ms);
		}
	};
}
