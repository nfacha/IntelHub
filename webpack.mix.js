const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("assets/js/app.js", "public/build/dist/js")
	.js("assets/js/ckeditor-classic.js", "public/build/dist/js")
	.js("assets/js/ckeditor-inline.js", "public/build/dist/js")
	.js("assets/js/ckeditor-balloon.js", "public/build/dist/js")
	.js("assets/js/ckeditor-balloon-block.js", "public/build/dist/js")
	.js("assets/js/ckeditor-document.js", "public/build/dist/js")
	.options({
		processCssUrls: false,
	})
	// .copyDirectory("src/json", "public/build/dist/json")
	// .copyDirectory("src/fonts", "public/build/dist/dist/fonts")
	.copyDirectory("assets/images", "public/dist/images");
