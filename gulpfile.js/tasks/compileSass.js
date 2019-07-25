const gulp = require('gulp');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass');
const sourceMaps = require('gulp-sourcemaps');
const cssBase64 = require('gulp-css-base64');
const rename = require('gulp-rename');

const dest_dir = `./build/css/frontend/`;

const compileSass = (cb) => (
	gulp.src(`./src/sass/*.{sass,scss}`)
		.pipe(plumber(error => {
			console.error(error.messageFormatted || error.message);
			cb();
		}))
		.pipe(sourceMaps.init())
		.pipe(sass())
		.pipe(sourceMaps.write())
		.pipe(cssBase64({
			extensionsAllowed: ['.svg']
		}))
		.pipe(gulp.dest(dest_dir))
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(gulp.dest(dest_dir))
);

compileSass.displayName = `sass@compile`;

module.exports = compileSass;