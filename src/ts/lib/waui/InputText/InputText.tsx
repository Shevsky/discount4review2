import React, { ChangeEvent, Component, FocusEvent, ReactElement, RefObject } from 'react';
import Styles from './InputText.sass';
import ClassNames from 'classnames';

type TInputTextValue = string | number;
type TInputTextType = 'text' | 'password' | 'int' | 'float';

export interface IInputTextProps {
	className?: string;
	refNode?: RefObject<any>;
	type?: TInputTextType;
	short?: boolean;
	middle?: boolean;
	allowEmpty?: boolean;
	allowedSymbols?: string;
	[prop: string]: any;
}

interface IInputTextPropsFinal extends IInputTextProps {
	value: TInputTextValue;
	params?: any;
	onChange: (value: TInputTextValue, params?: any) => void;
}

interface IInputTextState {
	value: TInputTextValue;
}

export default class InputText extends Component<IInputTextPropsFinal, IInputTextState> {
	constructor(props) {
		super(props);

		this.state = {
			value: props.value
		};
	}

	render(): ReactElement<HTMLInputElement> {
		const {
			className,
			refNode,
			short = false,
			middle = false,
			allowEmpty,
			allowedSymbols,
			params,
			...props
		} = this.props;
		const inputClass = ClassNames(Styles.inputText, {
			[className]: !!className,
			[Styles.inputText_short]: short,
			[Styles.inputText_middle]: middle
		});

		return (
			<input
				className={inputClass}
				ref={refNode}
				{...props}
				value={this.value}
				onChange={this.handleChange}
				onBlur={this.handleBlur}
				type={this.type}
			/>
		);
	}

	UNSAFE_componentWillReceiveProps(nextProps: Readonly<IInputTextPropsFinal>) {
		if (nextProps.value !== this.value) {
			this.value = nextProps.value;
		}
	}

	get value(): TInputTextValue {
		return this.state.value;
	}

	set value(value: TInputTextValue) {
		this.setState({ value });
	}

	get type(): string {
		const { type } = this.props;

		if (['password'].includes(type)) {
			return type;
		} else if (type === 'int') {
			return 'number';
		} else {
			return 'text';
		}
	}

	get is_deferred_handler(): boolean {
		const { type, allowedSymbols = '' } = this.props;

		return ['float'].includes(type) || allowedSymbols.length > 0;
	}

	protected triggerChange(value: TInputTextValue) {
		const { onChange, params } = this.props;

		onChange(value, params);
	}

	protected processValue(value: TInputTextValue): TInputTextValue {
		const { type, allowedSymbols = '', allowEmpty = false } = this.props;

		if (value === '' && allowEmpty) {
			return value;
		}

		if (type === 'int') {
			value = parseInt(value as string);
			if (isNaN(value)) {
				value = 0;
			}
		} else if (type === 'float') {
			value = (value as string).replace(',', '.');
			value = parseFloat(value as string);
			if (isNaN(value)) {
				value = 0;
			}
		} else if (allowedSymbols.length > 0) {
			value = (value as string).replace(new RegExp('[^' + allowedSymbols + ']', 'ig'), '');
		}

		return value;
	}

	private handleChange = (e: ChangeEvent<HTMLInputElement>) => {
		const {
			target: { value }
		} = e;

		this.value = value as TInputTextValue;

		if (this.is_deferred_handler) {
			return;
		}

		this.triggerChange(value);
	};

	private handleBlur = (e: FocusEvent<HTMLInputElement>) => {
		if (!this.is_deferred_handler) {
			return;
		}

		let value = e.target.value as TInputTextValue;
		value = this.processValue(value);

		this.value = value;

		this.triggerChange(value);
	};
}
