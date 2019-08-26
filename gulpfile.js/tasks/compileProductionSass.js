const gulp = require('gulp');
const sass = require('gulp-sass');
const csso = require('gulp-csso');
const cssbeautify = require('gulp-cssbeautify');
const cssSvg = require('gulp-css-svg');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');

const dest_dir = `./build/css/frontend/`;

const compileProductionSass = () =>
	gulp
		.src(`./src/sass/*.{sass,scss}`)
		.pipe(sass())
		.pipe(cssSvg())
		.pipe(autoprefixer())
		.pipe(csso())
		.pipe(
			cssbeautify(
				cssbeautify({
					indent: '\t'
				})
			)
		)
		.pipe(gulp.dest(dest_dir))
		.pipe(
			cleanCSS({
				level: {
					0: {
						all: true
					},
					1: {
						all: true
					},
					2: {
						all: true
					}
				}
			})
		)
		.pipe(
			rename({
				suffix: '.min'
			})
		)
		.pipe(gulp.dest(dest_dir));

compileProductionSass.displayName = `sass@compile_prod`;

module.exports = compileProductionSass;
