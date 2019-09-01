import React, { MouseEvent } from 'react';
import Link from '../Link/Link';
import Icon from 'lib/waui/Icon/Icon';
import Styles from './InlineLink.sass';
import ClassNames from 'classnames';

const InlineLink = ({
	className,
	children,
	icon,
	...props
}: {
	className?: string;
	href?: string;
	children: any;
	icon?: {
		name: string;
		size?: number;
	};
	onClick?: (e: MouseEvent<HTMLElement>) => boolean;
}) => {
	const linkClass = ClassNames('inline-link', {
		[className]: !!className
	});
	const iconClass = ClassNames(Styles.inlineLink__icon);

	return (
		<Link className={linkClass} {...props}>
			{!!icon && <Icon className={iconClass} {...icon} />}
			<b>
				<i>{children}</i>
			</b>
		</Link>
	);
};

export default InlineLink;
