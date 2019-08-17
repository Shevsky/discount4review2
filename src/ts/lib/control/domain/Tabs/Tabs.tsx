import React, { ReactElement } from 'react';
import InitialTabs, { ITabsProps } from 'lib/waui/Tabs/Tabs';

const Tabs = (props: ITabsProps): ReactElement<InitialTabs> => {
	let { id = '' } = props;
	if (id !== '') {
		id = `d4r.${id}`;
	}

	return (
		<InitialTabs {...props} id={id}>
			{props.children}
		</InitialTabs>
	);
};

export default Tabs;
