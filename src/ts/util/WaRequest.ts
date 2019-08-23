import Cookies from 'js-cookie';

type TWaRequestStatus = 'ok' | 'fail';

type TWaRequestError = string | string[] | Array<string[]>;

type TWaRequestMethod = 'GET' | 'POST';

type TWaRequestData = {
	[name: string]: any;
	_csrf?: string;
};

type TWaRequestPromise<D = any> = Promise<D>;

type TWaRequestFailType = 'error' | 'abort' | 'undefined';

interface IWaRequestFail {
	type: TWaRequestFailType;
	message: string;
	response?: any;
}

interface IWaRequestResponse<D = any> {
	status: TWaRequestStatus;
	data?: D;
	errors?: TWaRequestError;
}

export default new class WaRequest {
	static isSuccess(response: IWaRequestResponse): boolean {
		return response && 'status' in response && response.status === 'ok';
	}

	static isFail(response: IWaRequestResponse): boolean {
		return response && 'status' in response && response.status === 'fail';
	}

	static isStringlyError(error: TWaRequestError): boolean {
		return typeof error === 'string';
	}

	static isArrayedError(error: TWaRequestError): boolean {
		return error instanceof Array && 0 in error && typeof error[0] === 'string';
	}

	static isDeepArrayedError(error: TWaRequestError): boolean {
		return (
			error instanceof Array &&
			0 in error &&
			error[0] instanceof Array &&
			// @ts-ignore
			0 in error[0] &&
			typeof error[0][0] === 'string'
		);
	}

	static hasError(response: IWaRequestResponse): boolean {
		if (!response || !('errors' in response)) {
			return false;
		}

		const { errors: error } = response;

		return (
			WaRequest.isStringlyError(error) ||
			WaRequest.isArrayedError(error) ||
			WaRequest.isDeepArrayedError(error)
		);
	}

	static hasData(response: IWaRequestResponse): boolean {
		return response && 'data' in response;
	}

	private static buildFail(
		type: TWaRequestFailType,
		response?: any,
		message?: string
	): IWaRequestFail {
		return {
			type,
			message: typeof message === 'string' ? message : '',
			response: response
		};
	}

	private static fillForm(form: FormData, data: TWaRequestData, parent?: string) {
		if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File)) {
			for (let name in data) {
				WaRequest.fillForm(form, data[name], parent ? parent + '[' + name + ']' : name);
			}
		} else {
			const value: string = (data === null ? '' : data) as string;

			form.append(parent, value);
		}
	}

	private static buildForm(data: TWaRequestData): FormData {
		const form = new FormData();

		WaRequest.fillForm(form, data);

		return form;
	}

	get<D = any>(url: string, data: TWaRequestData): TWaRequestPromise<D> {
		return this.request('GET', url, data);
	}

	post<D = any>(url: string, data: TWaRequestData): TWaRequestPromise<D> {
		return this.request('POST', url, data);
	}

	protected workup(data: TWaRequestData) {
		data._csrf = Cookies.get('_csrf');
	}

	protected request<D = any>(
		method: TWaRequestMethod,
		url: string,
		data: TWaRequestData
	): TWaRequestPromise<D> {
		const xhr = new XMLHttpRequest();
		xhr.open(method, url, true);
		xhr.responseType = 'json';

		this.workup(data);
		const form = WaRequest.buildForm(data);

		return new Promise((resolve, reject) => {
			xhr.onload = () => {
				const response: IWaRequestResponse<D> = xhr.response;

				this.handleRequestLoad(response, resolve, reject);
			};

			xhr.onabort = () => {
				this.handleRequestAbort(xhr.response, resolve, reject);
			};

			xhr.send(form);
		});
	}

	private handleRequestLoad = <D = any>(response: IWaRequestResponse<D>, resolve, reject) => {
		if (WaRequest.isSuccess(response)) {
			this.handleRequestLoadSuccess(response, resolve, reject);
		} else if (WaRequest.isFail(response) && WaRequest.hasError(response)) {
			this.handleRequestLoadError(response, resolve, reject);
		} else {
			this.handleRequestLoadUndefinedError(response, resolve, reject);
		}
	};

	private handleRequestLoadSuccess = <D = any>(
		response: IWaRequestResponse<D>,
		resolve,
		reject
	) => {
		let data;
		if (WaRequest.hasData(response)) {
			data = response.data;
		} else {
			data = null;
		}

		resolve(data);
	};

	private handleRequestLoadError = <D = any>(response: IWaRequestResponse<D>, resolve, reject) => {
		const { errors: error } = response;
		let message;

		if (WaRequest.isStringlyError(error)) {
			message = error;
		} else if (WaRequest.isArrayedError(error)) {
			message = error[0];
		} else if (WaRequest.isDeepArrayedError(error)) {
			message = error[0][0];
		}

		reject(WaRequest.buildFail('error', response, message));
	};

	private handleRequestLoadUndefinedError = <D = any>(
		response: IWaRequestResponse<D>,
		resolve,
		reject
	) => {
		// tslint:disable:no-console
		console.warn('Не удалось выполнить запрос', response);
		reject(WaRequest.buildFail('undefined', response));
	};

	private handleRequestAbort = <D = any>(response: IWaRequestResponse<D>, resolve, reject) => {
		// tslint:disable:no-console
		console.warn('Запрос был прерван', response);
		reject(WaRequest.buildFail('abort', response));
	};
}();
