const gulp = require('gulp');
const newer = require('gulp-newer');

const dest_dir = `./build/`;

const copyDist = () => (
	gulp.src([`./src/dist/**`, `./src/dist/**/.*`])
		.pipe(newer(dest_dir))
		.pipe(gulp.dest(dest_dir))
);

copyDist.displayName = `dist@copy`;

module.exports = copyDist;