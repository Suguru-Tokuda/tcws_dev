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
  dashgumCustomCSSSource: 'src/assets/css/dashgum_css/custom/*.css',
  dashgumVendorCSSSource: 'src/assets/css/dashgum_css/vendor/*.css',
  dashgumFooterJSSource: 'src/assets/js/dashgum_js/footer/*.js',
  dashgumHeaderJSSource: 'src/assets/js/dashgum_js/header/*.js',
  dashgumFontsSource: 'src/assets/fonts/dashgum_fonts/',
  dashgumImgSorce: 'src/assets/img/dashgum_img/*',
  jsDest: './assets/js',
  cssDest: './assets/css',
  imageDest: './assets/images',
  dashgumLineconsDest: './assets/css/fonts',
  dashgumFontsDest: './assets/fonts'
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

gulp.task('compress-dashgum-custom-css', function() {
  var stream = gulp.src(paths.dashgumCustomCSSSource)
  .pipe(order([
    'style.css',
    'style-responsive.css',
    'table-responsive.css',
    'to-do.css'
  ]))
  .pipe(concat('admin_custom_style.css'))
  .pipe(gulp.dest(paths.cssDest));
  return stream;
});

gulp.task('compress-dashgum-vendor-css', function() {
  var stream = gulp.src(paths.dashgumVendorCSSSource)
  .pipe(concat('admin_vendor_style.css'))
  .pipe(gulp.dest(paths.cssDest));
  return stream;
});

gulp.task('compress-dashgum-footer-js', function() {
  var stream = gulp.src(paths.dashgumFooterJSSource)
  .pipe(order([
    'jquery.js',
    'jquery-1.8.3.min.js',
    'jquery.fancybox.js',
    'bootstrap.min.js',
    'jquery.dcjqaccordion.2.7.js',
    'jquery.scrollTo.min.js',
    'jquery.nicescroll.js',
    'jquery.sparkline.js',
    'common-scripts.js',
    'jquery.gritter.js',
    'calendar-conf-events.js',
    'jquery-ui.js',
    'tasks.js',
    'jquery-ui-1.9.2.custom.min.js',
    'bootstrap-switch.js',
    'jquery.transinput.js',
    'daterangepicker.js',
    'jquery.backstretch.min.js',
    'rapahel-min.js',
    'morris.min.js',
    'Chart.js',
    'chartjs-conf.js',
    'zabuto_calendar.js',
  ]))
  .pipe(concat('admin_footer.js'))
  .pipe(gulp.dest(paths.jsDest));
  return stream;
});

gulp.task('publish-dashgum-images', function() {
  var stream = gulp.src(paths.dashgumImgSorce)
  .pipe(gulp.dest(paths.imageDest))
  return stream;
});

gulp.task('compress-dashgum-header-js', function() {
  var stream = gulp.src(paths.dashgumHeaderJSSource)
  .pipe(concat('admin_header.js'))
  .pipe(gulp.dest(paths.jsDest));
  return stream;
});

gulp.task('publish-dashgum-fonts', function() {
  gulp.src(paths.dashgumFontsSource + 'linecons/*')
  .pipe(gulp.dest(paths.dashgumLineconsDest));
  gulp.src(paths.dashgumFontsSource + 'fontawesome/*')
  .pipe(gulp.dest(paths.dashgumFontsDest));
  gulp.src(paths.dashgumFontsSource + 'glyphicons/*')
  .pipe(gulp.dest(paths.dashgumFontsDest));
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
