import React, { ReactElement } from 'react';

const Header = ({ children }): ReactElement<HTMLHeadingElement> => {
	return <h1>{children}</h1>;
};

export default Header;
