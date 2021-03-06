import React, { ChangeEvent, Component, ReactElement, RefObject } from 'react';
import Styles from './Select.sass';
import ClassNames from 'classnames';

type TSelectValue = string | number;

export interface ISelectOption {
	value: TSelectValue;
	label: string;
	[prop: string]: any;
}

export interface ISelectProps {
	className?: string;
	refNode?: RefObject<any>;
	hasEmptyOption?: boolean;
	widthAuto?: boolean;
	short?: boolean;
	[prop: string]: any;
}

interface ISelectPropsFinal extends ISelectProps {
	options: ISelectOption[];
	value: TSelectValue;
	params?: any;
	onChange: (value: TSelectValue, params?: any) => void;
}

export default class Select extends Component<ISelectPropsFinal> {
	render(): ReactElement<HTMLSelectElement> {
		const {
			options = [],
			className,
			refNode,
			hasEmptyOption = false,
			widthAuto = false,
			short = false,
			value,
			params,
			...props
		} = this.props;
		const selectClass = ClassNames(Styles.select, {
			[className]: !!className,
			[Styles['select_width-auto']]: !!widthAuto,
			[Styles['select_short']]: !!short
		});

		return (
			<select
				className={selectClass}
				ref={refNode}
				{...props}
				value={value}
				onChange={this.handleChange}
			>
				{hasEmptyOption && <option />}
				{options.map(({ label, ...option }, idx) => (
					<option key={idx} {...option}>
						{label}
					</option>
				))}
			</select>
		);
	}

	private handleChange = (e: ChangeEvent<HTMLSelectElement>) => {
		const {
			target: { value }
		} = e;
		const { onChange, params } = this.props;

		onChange(value, params);
	};
}
