const fs = require('fs');

const gulp = require('gulp');

const svgSprites = require('gulp-svg-sprites');
const svgMin = require('gulp-svgmin');

const compileSvgSprite = () => (
	gulp.src(['./src/svg_sprite/**/*.svg'])
		.pipe(svgSprites({
			cleanconfig: {
				plugins: [
					{cleanupIDs: false}
				]
			},
			mode: 'symbols',
			svgId: 'd4r_%f',
			preview: false,
			templates: {
				symbols: fs.readFileSync('./src/svg_sprite/template.tmpl')
			},
			svg: {
				symbols: 'sprite.svg'
			}
		}))
		.pipe(svgMin({
			plugins: [
				{removeUselessDefs: false},
				{cleanupIDs: false}
			]
		}))
		.pipe(gulp.dest('./build/img/'))
);

compileSvgSprite.displayName = 'svg_sprite@compile';

module.exports = compileSvgSprite;