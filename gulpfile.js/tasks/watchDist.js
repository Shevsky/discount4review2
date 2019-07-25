const path = require('path');
const del = require('del');
const gulp = require('gulp');
const copyDist = require('./copyDist');

const src_dir = `./src/dist/`;
const dest_dir = `./build/`;

const watchDist = () => {
	const watcher = gulp.watch([`./**/*`, `./**/.*`], {cwd: src_dir}, copyDist);

	watcher.on('unlink', file => {
		del(path.resolve(dest_dir, file));
	});

	return watcher;
};

watchDist.displayName = `dist@watch`;

module.exports = watchDist;