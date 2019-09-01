import React, { Component, ReactNode } from 'react';
import Styles from './FieldGroup.sass';
import ClassNames from 'classnames';
import Icon from 'lib/waui/Icon/Icon';

interface IFieldGroupProps {
	title: ReactNode;
	children: ReactNode[];
	collapse?: boolean;
}

interface IFieldGroupState {
	is_collapse: boolean;
}

export default class FieldGroup extends Component<IFieldGroupProps, IFieldGroupState> {
	state = {
		is_collapse: true
	};

	render(): ReactNode {
		const { title, children } = this.props;

		const fieldGroupClass = ClassNames(Styles.fieldGroup);
		const titleClass = ClassNames(Styles.fieldGroup__title, {
			[Styles.fieldGroup__title_canCollapse]: this.can_collapse
		});
		const titleIconClass = ClassNames(Styles.fieldGroup__titleIcon);
		const fieldsClass = ClassNames(Styles.fieldGroup__fields);

		return (
			<div className={fieldGroupClass}>
				<div className={titleClass} onClick={this.handleClickTitle}>
					{title}
					{this.can_collapse && (
						<Icon className={titleIconClass} name={this.is_collapse ? 'rarr' : 'darr'} />
					)}
				</div>
				{(!this.can_collapse || this.is_collapse) && <div className={fieldsClass}>{children}</div>}
			</div>
		);
	}

	get can_collapse(): boolean {
		return this.props.collapse || true;
	}

	get is_collapse(): boolean {
		return this.state.is_collapse;
	}

	set is_collapse(is_collapse: boolean) {
		this.setState({ is_collapse });
	}

	private handleClickTitle = () => {
		this.is_collapse = !this.is_collapse;
	};
}
