import React, { Component, ReactElement, ReactNode } from 'react';
import Styles from './Tab.sass';
import ClassNames from 'classnames';

export interface ITabProps {
	className?: string;
	children?: ReactNode;
	link?: string;
	label: ReactNode;
	switcherClassName?: string;
}

export default class Tab extends Component<ITabProps> {
	render(): ReactElement<HTMLDivElement> {
		const { className, children } = this.props;
		const tabClass = ClassNames(Styles.tab, {
			[className]: !!className
		});

		return <div className={tabClass}>{children}</div>;
	}
}
