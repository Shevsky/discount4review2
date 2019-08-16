import React, { ChangeEvent, Component, ReactElement, RefObject } from 'react';
import Styles from './Select.sass';
import ClassNames from 'classnames';

type TSelectValue = string | number;

interface ISelectOption {
	value: TSelectValue;
	label: string;
	[prop: string]: any;
}

export default class Select extends Component<{
	options: ISelectOption[];
	className?: string;
	refNode?: RefObject<any>;
	value: TSelectValue;
	hasEmptyOption?: boolean;
	widthAuto?: boolean;
	short?: boolean;
	params?: any;
	onChange: (value: TSelectValue, params?: any) => void;
	[prop: string]: any;
}> {
	render(): ReactElement<HTMLSelectElement> {
		const {
			options = [],
			className,
			refNode,
			hasEmptyOption = false,
			widthAuto = false,
			short = false,
			value,
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
