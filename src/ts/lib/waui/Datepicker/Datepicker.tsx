import React, { Component, ReactElement } from 'react';
import Styles from './Datepicker.sass';
import ClassNames from 'classnames';
import moment from 'moment';
import ru from 'date-fns/locale/ru';
import DatePicker, { registerLocale } from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';
import InlineLink from 'lib/waui/InlineLink/InlineLink';
registerLocale('ru', ru);

export interface IBaseDatepickerProps {
	className?: string;
	withTime?: boolean;
	disabled?: boolean;
	params?: any;
}

interface IMomentDatepickerProps extends IBaseDatepickerProps {
	moment: moment.Moment;
	onChange: (new_moment: moment.Moment, params?: any) => void;
}

interface IDateDatepickerProps extends IBaseDatepickerProps {
	date: Date;
	onChange: (new_date: Date, params?: any) => void;
}

export type TDatepickerProps = IMomentDatepickerProps | IDateDatepickerProps;

moment.locale('ru');

export default class Datepicker extends Component<TDatepickerProps> {
	render(): ReactElement<HTMLDivElement> {
		const { className, withTime = false, disabled = false } = this.props;
		const datepickerClass = ClassNames(Styles.datepicker, {
			[className]: !!className
		});
		const linkClass = ClassNames(Styles.datepicker__link, {
			[Styles.datepicker__link_disabled]: !!disabled
		});

		return (
			<div className={datepickerClass}>
				<DatePicker
					locale="ru"
					selected={this.selected_date}
					onChange={this.handleChange}
					showTimeSelect={withTime}
					timeFormat="HH:mm"
					timeIntervals={10}
					maxDate={this.current_date}
					timeCaption="Время"
					disabled={disabled}
					customInput={
						<div>
							<InlineLink
								icon={{
									name: 'calendar'
								}}
								className={linkClass}
							>
								{this.selected_moment.format(!withTime ? 'LL' : 'LL в HH:mm')}
							</InlineLink>
						</div>
					}
				/>
			</div>
		);
	}

	get is_moment(): boolean {
		return 'moment' in this.props && !('date' in this.props);
	}

	get moment(): moment.Moment {
		if (this.is_moment) {
			const props = this.props as IMomentDatepickerProps;
			return props.moment;
		} else {
			throw '"moment" отсутствует';
		}
	}

	get date(): Date {
		if (!this.is_moment) {
			const props = this.props as IDateDatepickerProps;
			return props.date;
		} else {
			throw '"date" отсутствует';
		}
	}

	get selected_date(): Date {
		if (this.is_moment) {
			return this.moment.toDate();
		} else {
			return this.date;
		}
	}

	get selected_moment(): moment.Moment {
		if (this.is_moment) {
			return this.moment;
		} else {
			return moment(this.date);
		}
	}

	get current_date(): Date {
		return new Date();
	}

	handleChange = (date: Date) => {
		const { onChange, params } = this.props;

		if (typeof onChange === 'function') {
			if (this.is_moment) {
				const moment_data = moment(date);
				// @ts-ignore
				onChange(moment_data, params);
			} else {
				// @ts-ignore
				onChange(date, params);
			}
		}
	};
}
