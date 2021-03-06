import React, { MouseEvent } from 'react';
import Styles from './Link.sass';
import ClassNames from 'classnames';

const Link = ({
	href,
	children,
	...props
}: {
	className?: string;
	href?: string;
	children: any;
	onClick?: (e: MouseEvent<HTMLElement>) => boolean;
}) => {
	const { className = '' } = props;
	const linkClass = ClassNames(Styles.link, {
		[className]: !!className
	});

	return (
		<a href={href || null} {...props} className={linkClass}>
			{children}
		</a>
	);
};

export default Link;
