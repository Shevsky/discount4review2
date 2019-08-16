import React, { MouseEvent } from 'react';

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
	return (
		<a href={href || 'javascript: void(0);'} {...props}>
			{children}
		</a>
	);
};

export default Link;
