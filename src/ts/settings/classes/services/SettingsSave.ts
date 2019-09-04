import { observable, observe } from 'util/mobx';
import WaRequest from 'util/WaRequest';
import { IObjectDidChange } from 'mobx';

export namespace SettingsSave {
	export interface IModels {
		[id: string]: ISettingsModel;
	}

	export type TStatus = 'waiting' | 'loading' | 'done' | 'error';

	export type THandler = (status: TStatus, message?: string) => void;

	export type THandlers = { [status in TStatus]: THandler[] };

	export class Service {
		@observable
		private status: TStatus = 'waiting';
		private message: string;

		private readonly models: IModels;
		private readonly url: string;
		private readonly handlers: THandlers = {} as THandlers;

		constructor(models: IModels, url: string) {
			this.models = models;
			this.url = url;

			this.bindDispatchers();
		}

		subscribe(handler: THandler, ...statuses: TStatus[]) {
			statuses.forEach(status => {
				if (!this.handlers.hasOwnProperty(status)) {
					this.handlers[status] = [];
				}

				this.handlers[status].push(handler);
			});
		}

		execute() {
			if (!this.has_modifies) {
				return;
			}

			this.freeze();

			this.status = 'loading';

			WaRequest.post<{ test: number }>(
				this.url,
				Object.assign(
					{},
					...Object.entries(this.models).map(([id, model]) => ({
						[id]: JSON.stringify(model.toJS())
					}))
				)
			)
				.then(data => {
					this.models_array.forEach(model => model.resetAllModifiedFlags());

					this.status = 'done';
				})
				.catch(fail => {
					const { message, response } = fail;

					if (message) {
						this.error = message;
					} else {
						this.error = 'Неизвестная ошибка';
						// tslint:disable-next-line
						console.warn(response);
					}
				})
				.finally(() => {
					this.unfreeze();
				});
		}

		protected get models_array(): ISettingsModel[] {
			return Object.values(this.models);
		}

		protected get has_modifies(): boolean {
			return this.models_array.some(model => model.hasAnyModifies());
		}

		protected set error(message: string) {
			this.message = message;
			this.status = 'error';
		}

		private bindDispatchers() {
			observe(this, (change: IObjectDidChange) => {
				if (change.name === 'status') {
					const params = [];
					if (this.status === 'error') {
						params.push(this.message);
					}

					this.dispatch(this.status, ...params);
				}
			});
		}

		private dispatch(status: TStatus, ...params) {
			if (!this.handlers.hasOwnProperty(status)) {
				return;
			}

			this.handlers[status].forEach(handler => handler(this.status, ...params));
		}

		private freeze() {
			this.models_array.forEach(model => model.freeze());
		}

		private unfreeze() {
			this.models_array.forEach(model => model.unfreeze());
		}
	}
}
