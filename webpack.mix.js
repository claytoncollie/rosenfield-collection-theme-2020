const mix = require('laravel-mix');

/*
 * Sets the path to the generated assets. By default, this is the root folder in
 * the theme. If doing something custom, make sure to change this everywhere.
 */
mix.setPublicPath('./dist');
mix.setResourceRoot('../dist');

/**
 * Disable the manifest.json file and license file from being created.
 * We are using filemtime for the assets to bust cache when they are changed.
 */
mix.options({
	manifest: false,
	terser: {
		extractComments: false,
	},
});

/**
 * Include jQuery in our build to make sure it binds to functions like select2.
 */
mix.webpackConfig({
	externals: {
		$: 'jQuery',
		jquery: 'jQuery',
	},
});

/**
 * Generate sourcemaps for CSS and JS files to easily find info in the console.
 */
mix.sourceMaps();
mix.webpackConfig({
	devtool: 'source-map',
});

/**
 * Javascript
 */
mix.js('assets/js/frontend.js', 'dist');

/**
 * Css
 */
mix.sass('assets/scss/main.scss', 'dist', {
	sassOptions: {
		outputStyle: 'compressed',
	},
});
mix.sass('assets/scss/editor.scss', 'dist', {
	sassOptions: {
		outputStyle: 'compressed',
	},
});
