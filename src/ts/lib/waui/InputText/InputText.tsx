import React, { ChangeEvent, Component, FocusEvent, ReactElement, RefObject } from 'react';
import Styles from './InputText.sass';
import ClassNames from 'classnames';

type TInputTextValue = string | number;
type TInputTextType = 'text' | 'password' | 'int' | 'float';

export interface IInputTextProps {
	className?: string;
	refNode?: RefObject<any>;
	type?: TInputTextType;
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
		const { className, refNode, params, ...props } = this.props;
		const inputClass = ClassNames(Styles.inputText, {
			className: !!className
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

	componentWillReceiveProps(nextProps: Readonly<IInputTextPropsFinal>) {
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

		if (type === 'password') {
			return type;
		} else {
			return 'text';
		}
	}

	get is_deferred_handler(): boolean {
		const { type } = this.props;

		return ['int', 'float'].includes(type);
	}

	protected triggerChange(value: TInputTextValue) {
		const { onChange, params } = this.props;

		onChange(value, params);
	}

	protected processValue(value: TInputTextValue): TInputTextValue {
		const { type } = this.props;

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

		this.triggerChange(value);
	};
}
