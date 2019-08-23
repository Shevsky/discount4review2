import React, { MouseEvent } from 'react';
import Link from 'lib/waui/Link/Link';
import Icon from 'lib/waui/Icon/Icon';
import Styles from './Button.sass';
import ClassNames from 'classnames';

const Button = ({
	className,
	children,
	icon,
	type,
	...props
}: {
	className?: string;
	children: any;
	icon?: {
		name: string;
		size?: number;
	};
	type?: string;
	onClick?: (e: MouseEvent<HTMLElement>) => boolean;
}) => {
	if (type === 'delete') {
		type = Styles['button_delete'];
	}

	const linkClass = ClassNames('button', Styles.button, {
		[className]: !!className,
		[type]: !!type
	});
	const iconClass = ClassNames(Styles.button__icon);

	return (
		<Link className={linkClass} {...props}>
			{!!icon && <Icon className={iconClass} {...icon} />}
			{children}
		</Link>
	);
};

export default Button;
