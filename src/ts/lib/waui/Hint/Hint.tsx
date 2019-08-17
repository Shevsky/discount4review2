import React, { ReactElement } from 'react';
import Styles from './Hint.sass';
import ClassNames from 'classnames';

const Hint = ({
	children,
	small = false,
	paddedLeft = false,
	paddedBottom = false,
	likeHeader = false,
	className = ''
}): ReactElement<any> => {
	const hintClass = ClassNames(Styles.hint, {
		[Styles.hint_small]: small,
		[Styles.hint_paddedLeft]: paddedLeft,
		[Styles.hint_paddedBottom]: paddedBottom,
		[Styles.hint_likeHeader]: likeHeader,
		[className]: !!className
	});

	return <span className={hintClass}>{children}</span>;
};

export default Hint;
