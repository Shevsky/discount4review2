const del = require('del');

const deleteBuild = () => (
	del('./build/')
);

deleteBuild.displayName = 'delete_build';

module.exports = deleteBuild;