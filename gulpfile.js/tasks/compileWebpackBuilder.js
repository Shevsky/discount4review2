const gulp = require('gulp');

const plumber = require('gulp-plumber');

const webpack = require('webpack');
const webpack_stream = require('webpack-stream');

const compileWebpackBuilder = (config_path, name) => {
	const webpack_config = require(config_path);

	const compileWebpack = (done) => (
		gulp.src('./src/webpack_js/index.js')
			.pipe(plumber((error) => {
				console.error(error.messageFormatted);
				done();
			}))
			.pipe(webpack_stream(webpack_config, webpack))
			.pipe(gulp.dest('./build/'))
	);

	compileWebpack.displayName = `webpack@${name}`;

	return compileWebpack;
};

module.exports = compileWebpackBuilder;