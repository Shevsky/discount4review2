const gulp = require('gulp');
const compileSass = require('./compileSass');

const watchSass = () => (
	gulp.watch([`./src/sass/**/*.{sass,scss}`], compileSass)
);

watchSass.displayName = `sass@watch`;

module.exports = watchSass;