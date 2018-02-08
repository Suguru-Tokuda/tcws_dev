var gulp = require('gulp'); // npm install --save-dev gulp

var plumber = require('gulp-plumber'); // npm install --save-dev gulp-plumber
var concat = require('gulp-concat'); // npm install --save-dev gulp-concat
var livereload = require('gulp-livereload'); // npm install --save-dev gulp-livereload
var ignore = require('gulp-ignore'); // npm install --save-dev gulp-ignore
var minify = require('gulp-minify'); // npm install --save-dev gulp-minify
var order = require('gulp-order'); // npm install --save-dev gulp-order

var gulpFilter = require('gulp-filter'); // npm install --save-dev gulp-filter
var mainBowerFiles = require('main-bower-files'); // npm install --save-dev main-bower-files

var paths = {
  mainCSSSource: ['src/assets/css/unishop_css/vendor.min.css', 'src/assets/css/unishop_css/styles.min.css'],
  unishopCSSSource: 'src/**/*.css',
  jsDest: './assets/js',
  cssDest: './assets/css'
};

gulp.task('compress-main-css', function() {
  var stream = gulp.src(paths.mainCSSSource)
  .pipe(concat('main.css'))
  .pipe(gulp.dest(paths.cssDest));
  return stream;
});

gulp.task('compress-unishiop-css', function() {
  var stream = gulp.src(paths.unishopCSSSource)
  .pipe(order([
    'vendor.*.css',
    '*.min.css',
    'styles.*.css'
  ]))
  .pipe(concat('main.css'))
  .pipe(gulp.dest(paths.cssDest));
  return stream;
});

gulp.task('publish-components', function() {
  var jsFilter = gulpFilter('**/*.js', {restore: true});
  var cssFilter = gulpFilter('**/*.css', {restore: true});

  var stream = gulp.src(mainBowerFiles())
  .pipe(jsFilter)
  .pipe(gulp.dest(paths.jsDest))
  .pipe(jsFilter.restore);
  return stream;
});
