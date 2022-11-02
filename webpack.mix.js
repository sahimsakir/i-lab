/**
 * Laravel Mix
 * @type {Api}
 */
const mix = require('laravel-mix');

const postcssPresetEnv = require('postcss-preset-env');

mix.options({
  processCssUrls: true,
  cssNano: {
    preset: 'advanced',
    discardComments: { removeAll: true }
  },
  // PostCSS
  postCss: [
    require('postcss-font-magician')({
      variants: {
        'Open Sans': {
          '300': [],
          '400': [],
          '600': [],
          '700': []
        }
      }
    }),
    require('autoprefixer')({
      grid: 'autoplace'
    }),
    require('postcss-discard-duplicates'),
    require('postcss-convert-values'),
    require('postcss-discard-empty'),
    require('postcss-minify-font-values'),
    require('postcss-minify-gradients'),
    require('postcss-minify-params'),
    require('postcss-minify-selectors'),
    require('postcss-normalize-charset'),
    require('postcss-normalize-url'),
    require('postcss-ordered-values'),
    require('postcss-reduce-initial'),
    require('postcss-unique-selectors'),
    postcssPresetEnv({
      stage: 0
    })
  ],

  uglify: {
    uglifyOptions: {
      comments: false
    }
  }
});

mix.js('resources/js/app.js', 'public/js');

mix.sass('resources/sass/app.scss', 'public/css');

if (mix.inProduction()) {
  mix.version();
}

mix.browserSync('http://ilab_v01.test/');
