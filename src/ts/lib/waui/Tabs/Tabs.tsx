import React, { Component, MouseEvent, ReactElement, ReactNode } from 'react';
import Styles from './Tabs.sass';
import ClassNames from 'classnames';
import { ITabProps } from 'lib/waui/Tab/Tab';
import Cookies from 'js-cookie';

type TTab = ReactElement<ITabsProps>;

export interface ITabsProps {
	id?: string;
	children: TTab[];
	className?: string;
	onChange?: (index: number) => void;
}

interface ITabsState {
	selected_index: number;
}

export default class Tabs extends Component<ITabsProps, ITabsState> {
	constructor(props) {
		super(props);

		this.state = {
			selected_index: this.getDefaultIndex(props)
		};
	}

	render(): ReactElement<HTMLDivElement> {
		const { className } = this.props;
		const tabsClass = ClassNames(Styles.tabs, {
			[className]: !!className
		});
		const switcherClass = ClassNames(Styles.tabs__switcher);
		const switcherItemClass = ClassNames(Styles.tabs__switcherItem);
		const switcherItemSelectedClass = ClassNames(Styles.tabs__switcherItem_selected);
		const contentClass = ClassNames(Styles.tabs__content);

		return (
			<div className={tabsClass}>
				<div className={switcherClass}>
					{this.tabs.map((tab, idx) => {
						const { link = '', label, switcherClassName }: ITabProps = tab.props as ITabProps;
						const is_link = link !== '';
						const is_selected = idx === this.selected_index;

						const props = {};
						if (!is_link) {
							props['href'] = null;
							props['data-index'] = idx;
							props['onClick'] = this.handleClickTab;
						} else {
							props['href'] = link;
						}

						const currentSwitcherItemClass = ClassNames(switcherItemClass, {
							[switcherClassName]: !!switcherClassName,
							[switcherItemSelectedClass]: is_selected
						});

						return (
							<a className={currentSwitcherItemClass} key={idx} {...props}>
								{label}
							</a>
						);
					})}
				</div>

				<div className={contentClass}>{this.selected_tab}</div>
			</div>
		);
	}

	get id(): string {
		const { id = '' } = this.props;

		return id;
	}

	get cookie_id(): string {
		return `tabs.${this.id}`;
	}

	get is_saving(): boolean {
		return this.id !== '';
	}

	get selected_index(): number {
		return this.state.selected_index;
	}

	set selected_index(selected_index: number) {
		this.setState({ selected_index }, this.handleChangeIndex);
	}

	get tabs(): TTab[] {
		return this.props.children;
	}

	get selected_tab(): TTab {
		return this.props.children[this.selected_index];
	}

	getDefaultIndex(props: ITabsProps): number {
		const { id = '' } = props;

		if (id === '') {
			return 0;
		}

		return +Cookies.get(this.cookie_id) || 0;
	}

	private handleClickTab = (e: { target: HTMLDivElement }) => {
		const index: number = +e.target.dataset.index || 0;
		const tab = this.tabs[index];
		if (tab === undefined) {
			return;
		}

		const { onChange } = this.props;
		this.selected_index = index;
		if (typeof onChange === 'function') {
			onChange(index);
		}
	};

	private handleChangeIndex = () => {
		if (!this.is_saving) {
			return;
		}

		Cookies.set(this.cookie_id, this.selected_index.toString());
	};
}
