import React, { ReactElement } from 'react';
import Styles from './Field.sass';
import ClassNames from 'classnames';

const Field = ({
	className,
	label = '',
	hint,
	description,
	children,
	appendCenter = false,
	required = false,
	vertical = false,
	short = false
}: {
	className?: string;
	hint?: any;
	description?: string;
	label?: string;
	children: any;
	appendCenter?: boolean;
	required?: boolean;
	vertical?: boolean;
	short?: boolean;
}): ReactElement<any> => {
	const fieldClass = ClassNames(Styles.field, {
		[className]: !!className,
		[Styles.field_appendCenter]: appendCenter,
		[Styles.field_vertical]: vertical,
		[Styles.field_short]: short,
		[Styles.field_required]: required
	});
	const labelClass = ClassNames(Styles.field__label);
	const boxClass = ClassNames(Styles.field__box);
	const hintClass = ClassNames(Styles.field__hint);
	const descriptionClass = ClassNames(Styles.field__description);

	return (
		<div className={fieldClass}>
			<div className={labelClass}>
				{label}
				{!!description && <div className={descriptionClass}>{description}</div>}
			</div>
			<div className={boxClass}>
				{children}
				{!!hint && <div className={hintClass}>{hint}</div>}
			</div>
		</div>
	);
};

export default Field;
