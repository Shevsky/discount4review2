import cloneDeep from 'lodash.clonedeep';

const VarClone = (variable: any): any => {
	return cloneDeep(variable);
};

export default VarClone;
