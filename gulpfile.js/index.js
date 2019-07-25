const gulp = require('gulp');

const deleteBuild = require('./tasks/deleteBuild');
const copyDist = require('./tasks/copyDist');
const compileSvgSprite = require('./tasks/compileSvgSprite');
const compileSass = require('./tasks/compileSass');
const compileProductionSass = require('./tasks/compileProductionSass');
const compileWebpackBuilder = require('./tasks/compileWebpackBuilder');
const compileWebpack = compileWebpackBuilder('../../webpack.config.js', 'compile');
const compileProductionWebpack = compileWebpackBuilder('../../webpack.prod.js', 'compile_prod');

const watchDist = require('./tasks/watchDist');
const watchSass = require('./tasks/watchSass');
const watchWebpack = compileWebpackBuilder('../../webpack.watch.js', 'watch');

gulp.task('build', gulp.series(
	deleteBuild,
	compileSvgSprite,
	gulp.parallel(
		copyDist,
		compileProductionSass
	),
	compileProductionWebpack
));

gulp.task('dev', gulp.series(
	deleteBuild,
	compileSvgSprite,
	gulp.parallel(
		copyDist,
		compileSass
	),
	gulp.parallel(
		watchDist,
		watchSass,
		watchWebpack
	)
));