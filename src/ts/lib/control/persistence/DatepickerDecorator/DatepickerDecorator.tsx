import React, { Component, ReactElement } from 'react';
import Datepicker, { IBaseDatepickerProps, TDatepickerProps } from 'lib/waui/Datepicker/Datepicker';
import moment from 'moment';
import { WaUISetttings } from 'util/WaUISettings';
import { observer } from 'mobx-react';

export interface IDomainDatepickerDecoratorProps extends IBaseDatepickerProps {
	name: string;
	arrayAccess?: WaUISetttings.IArrayAccess;
}

export interface IDatepickerDecoratorProps extends IDomainDatepickerDecoratorProps {
	model: ISettingsModel;
}

@observer
export default class DatepickerDecorator extends Component<IDatepickerDecoratorProps> {
	render(): ReactElement<Datepicker> {
		const { name, model, arrayAccess, ...props } = this.props;

		return (
			<Datepicker
				{...props}
				moment={this.moment}
				params={{ name, model, arrayAccess }}
				onChange={this.handleChange}
			/>
		);
	}

	get moment(): moment.Moment {
		const { name, model, arrayAccess } = this.props;

		const value = WaUISetttings.Reader(name, model, arrayAccess);

		return moment(value);
	}

	get is_with_time(): boolean {
		return this.props.withTime || false;
	}

	private handleChange = (moment_data: moment.Moment, params: WaUISetttings.IParams) => {
		let value;
		if (this.is_with_time) {
			value = moment_data.format('YYYY-MM-DD HH:mm:ss');
		} else {
			value = moment_data.format('YYYY-MM-DD');
		}

		WaUISetttings.Handler(value, params);
	};
}
