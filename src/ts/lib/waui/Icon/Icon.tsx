import React, { MouseEvent } from 'react';
import Styles from './Icon.sass';
import ClassNames from 'classnames';

const Icon = ({
	className,
	name,
	size = 16,
	link = false,
	...props
}: {
	className?: string;
	name: string;
	size?: number;
	link?: boolean;
	onClick?: (e: MouseEvent<HTMLElement>) => boolean;
}) => {
	const iconClass = ClassNames(`icon${size.toString()}`, name, {
		[className]: !!className,
		[Styles.iconLink]: !!link
	});

	return <i className={iconClass} {...props} />;
};

export default Icon;
