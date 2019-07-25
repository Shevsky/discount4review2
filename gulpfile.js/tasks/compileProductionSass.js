const gulp = require('gulp');
const sass = require('gulp-sass');
const csso = require('gulp-csso');
const cssbeautify = require('gulp-cssbeautify');
const cssSvg = require('gulp-css-svg');
const autoprefixer = require('gulp-autoprefixer');
const cssmin = require('gulp-cssmin');
const rename = require('gulp-rename');

const dest_dir = `./build/css/frontend/`;

const compileProductionSass = () => (
	gulp.src(`./src/sass/*.{sass,scss}`)
		.pipe(sass())
		.pipe(cssSvg())
		.pipe(autoprefixer())
		.pipe(csso())
		.pipe(cssbeautify(cssbeautify({
			indent: '\t'
		})))
		.pipe(gulp.dest(dest_dir))
		.pipe(cssmin())
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(gulp.dest(dest_dir))
);

compileProductionSass.displayName = `sass@compile_prod`;

module.exports = compileProductionSass;