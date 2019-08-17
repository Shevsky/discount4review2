import React, { ReactElement } from 'react';
import Styles from './SubHeader.sass';
import ClassNames from 'classnames';

const SubHeader = ({ children, noShift = false }): ReactElement<any> => {
	const subHeaderClass = ClassNames(Styles.subheader, {
		[Styles.subheader__noShift]: noShift
	});

	return <h3 className={subHeaderClass}>{children}</h3>;
};

export default SubHeader;
