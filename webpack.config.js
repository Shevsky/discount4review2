const path = require('path');
const autoprefixer = require('autoprefixer');
const Extracter = require('mini-css-extract-plugin');

const extract = new Extracter({
	filename: 'css/[name].css'
});

module.exports = {
	stats: { children: false },
	mode: 'development',
	entry: {
		settings: './src/ts/settings/index.ts',
	},
	output: {
		path: path.resolve(__dirname, '../build'),
		filename: 'js/[name].js'
	},
	module: {
		rules: [
			{
				test: /\.tsx?$/,
				loader: ['ts-loader', 'tslint-loader']
			},
			{
				test: /\.js$/,
				loader: 'babel-loader',
				include: /node_modules\/helpful-decorators/,
				options: {
					presets: ['@babel/preset-env'],
					plugins: ['@babel/plugin-transform-block-scoping']
				}
			},
			{
				test: /\.(sass|scss)$/,
				use: [
					{
						loader: Extracter.loader
					},
					{
						loader: 'css-loader',
						options: {
							modules: true,
							camelCase: 'dashes',
							localIdentName: 'd4r-[local]'
						}
					},
					{
						loader: 'postcss-loader',
						options: {
							sourceMap: true,
							plugins: loader => [autoprefixer()]
						}
					},
					{
						loader: 'sass-loader'
					}
				],
				exclude: /node_modules|vendor/
			},
			{
				test: /\.(less|css)$/,
				use: [
					{
						loader: Extracter.loader
					},
					{
						loader: 'css-loader',
						options: {
							modules: true,
							camelCase: 'dashes',
							localIdentName: 'd4r-[local]'
						}
					},
					{
						loader: 'less-loader'
					},
					{
						loader: 'postcss-loader',
						options: {
							sourceMap: true,
							plugins: loader => [autoprefixer()]
						}
					}
				],
				exclude: /node_modules|vendor/
			},
			{
				test: /\.css$/,
				use: [
					{
						loader: Extracter.loader
					},
					{
						loader: 'css-loader'
					}
				],
				include: /node_modules|vendor/
			},
			{
				test: /\.(png|jpg|gif|svg)$/,
				loader: 'file-loader',
				options: {
					name: '[name].[ext]',
					outputPath: 'img/',
					publicPath: '../'
				}
			}
		]
	},
	plugins: [extract],
	resolve: {
		alias: {
			backend: path.resolve(__dirname, '../src/ts/backend'),
			frontend: path.resolve(__dirname, '../src/ts/frontend'),
			settings: path.resolve(__dirname, '../src/ts/settings'),
			lib: path.resolve(__dirname, '../src/ts/lib'),
			env: path.resolve(__dirname, '../src/ts/env'),
			util: path.resolve(__dirname, '../src/ts/util'),
			vendor: path.resolve(__dirname, '../src/ts/vendor')
		},
		extensions: ['.js', '.json', '.ts', '.tsx']
	},
	devtool: 'cheap-module-inline-source-map'
};
