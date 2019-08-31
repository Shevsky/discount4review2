const VarClone = (variable: any): any => {
	if (typeof variable !== 'object') {
		return variable;
	}

	if (!variable) {
		return variable;
	}

	const clone = variable instanceof Array ? [] : {};
	for (const prop in variable) {
		if (variable.hasOwnProperty(prop)) {
			clone[prop] = VarClone(variable[prop]);
		}
	}

	return clone;
};

export default VarClone;
