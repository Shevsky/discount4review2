import React, { Component, ReactElement, ReactNode } from 'react';
import Styles from './BottomFixedBar.sass';
import ClassNames from 'classnames';

interface IBottomFixedBarProps {
	children: ReactNode;
}

export default class BottomFixedBar extends Component<IBottomFixedBarProps> {
	render(): ReactElement<HTMLDivElement> {
		const { children } = this.props;

		const bottomFixedBarClass = ClassNames(Styles.bottomFixedBar);
		const innerClass = ClassNames(Styles.bottomFixedBar__inner);

		return (
			<div className={bottomFixedBarClass}>
				<div className={innerClass}>{children}</div>
			</div>
		);
	}
}
