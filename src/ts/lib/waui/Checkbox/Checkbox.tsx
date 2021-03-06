import React, { ChangeEvent, Component, ReactElement, ReactNode, RefObject } from 'react';
import Styles from './Checkbox.sass';
import ClassNames from 'classnames';

export interface ICheckboxProps {
	className?: string;
	refNode?: RefObject<any>;
	hint?: ReactNode;
	children?: ReactNode;
	[prop: string]: any;
}

interface ICheckboxPropsFinal extends ICheckboxProps {
	checked: boolean;
	onChange: (checked: boolean, params?: any) => void;
}

export default class Checkbox extends Component<ICheckboxPropsFinal> {
	render(): ReactElement<any> {
		const { checked, children, className, refNode, hint, params, ...props } = this.props;
		const labelClass = ClassNames(Styles.checkbox, {
			[className]: !!className
		});
		const boxClass = ClassNames(Styles.checkbox__box);
		const inputClass = ClassNames(Styles.checkbox__input);
		const contentClass = ClassNames(Styles.checkbox__content);
		const hintClass = ClassNames(Styles.checkbox__hint);

		return (
			<label className={labelClass}>
				<div className={boxClass}>
					<input
						type="checkbox"
						className={inputClass}
						ref={refNode}
						{...props}
						checked={checked}
						onChange={this.handleChange}
					/>
				</div>

				{(children || hint) && (
					<div className={contentClass}>
						{children}

						{hint && <span className={hintClass}>{hint}</span>}
					</div>
				)}
			</label>
		);
	}

	private handleChange = (e: ChangeEvent<HTMLInputElement>) => {
		const {
			target: { checked }
		} = e;
		const { onChange, params } = this.props;

		onChange(checked, params);
	};
}
