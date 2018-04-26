var gulp = require('gulp'); // npm install --save-dev gulp

var plumber = require('gulp-plumber'); // npm install --save-dev gulp-plumber
var concat = require('gulp-concat'); // npm install --save-dev gulp-concat
var livereload = require('gulp-livereload'); // npm install --save-dev gulp-livereload
var ignore = require('gulp-ignore'); // npm install --save-dev gulp-ignore
var minify = require('gulp-minify'); // npm install --save-dev gulp-minify
var order = require('gulp-order'); // npm install --save-dev gulp-order
var del = require('del'); // npm install --save-dev del
var uglify = require('gulp-uglify'); // npm install --save-dev uglify
var gulpFilter = require('gulp-filter'); // npm install --save-dev gulp-filter
var mainBowerFiles = require('main-bower-files'); // npm install --save-dev main-bower-files

var paths = {
  mainCSSSource: ['src/assets/css/unishop_css/vendor.min.css', 'src/assets/css/unishop_css/styles.min.css'],
  unishopVendorCSSSource: 'src/assets/css/unishop_css/vendor/*.css',
  unishopCustomCSSSource: 'src/assets/css/unishop_css/custom/*.css',
  unishopCustomJSSource: 'src/assets/js/unishop_js/custom/*.js',
  unishopVendorJSSource: 'src/assets/js/unishop_js/vendor/*.js',
  unishopVendorJSSource2: './assets/vendors/js/*.js',
  unishopVendorHeaderJSSource: 'src/assets/js/unishop_js/vendor/header/*.js',
  unishopVendorFooterJSSource: 'src/assets/js/unishop_js/vendor/footer/*.js',
  unishopFontsSource: 'src/assets/fonts/unishop_fonts/*',
  dashgumCustomCSSSource: 'src/assets/css/dashgum_css/custom/*.css',
  dashgumVendorCSSSource: 'src/assets/css/dashgum_css/vendor/*.css',
  dashgumFooterJSSource: 'src/assets/js/dashgum_js/footer/*.js',
  dashgumHeaderJSSource: 'src/assets/js/dashgum_js/header/*.js',
  dashgumCustomJSSource: 'src/assets/js/dashgum_js/custom/*.js',
  dashgumFontsSource: 'src/assets/fonts/dashgum_fonts/',
  dashgumImgSorce: 'src/assets/img/dashgum_img/*',
  jsDest: './assets/js',
  cssDest: './assets/css',
  imageDest: './assets/images',
  fontsDest: './assets/fonts',
  vendorJSDest: './assets/vendors/js',
  dashgumLineconsDest: './assets/css/fonts',
  dashgumFontsDest: './assets/fonts'
};

gulp.task('compress-unishiop-vendor-css', function() {
  gulp.src(paths.unishopVendorCSSSource)
  .pipe(order([
    "vendor.min.css",
    "card.min.css",
    "jquery.timepicker.css",
    "site.js"
  ]))
  .pipe(concat('unishop.vendor.min.css'))
  .pipe(gulp.dest(paths.cssDest));
  var stream = gulp.src('src/assets/css/unishop_css/vendor/styles.min.css.map')
  .pipe(gulp.dest(paths.cssDest));
  return stream;
});

gulp.task('compress-unishiop-custom-css', function() {
  var stream = gulp.src(paths.unishopCustomCSSSource)
  .pipe(concat('unishop.custom.min.css'))
  .pipe(gulp.dest(paths.cssDest));
  return stream;
});

gulp.task('compress-unishop-custom-js', function() {
  var stream = gulp.src(paths.unishopCustomJSSource)
  .pipe(order([
    "scripts.min.js",
    "customScripts.js"
  ]))
  .pipe(concat('unishop.custom.min.js'))
  .pipe(gulp.dest(paths.jsDest));
  return stream;
});

gulp.task('compress-unishop-vendor-js2', function() {
  var stream = gulp.src(paths.unishopVendorJSSource2)
  .pipe(order([
    "jquery.js",
    "jquery-ui.js"
  ]))
  .pipe(concat('unishop.vendor.header.js'))
  .pipe(gulp.dest(paths.jsDest));
  return stream;
});

gulp.task('compress-unishop-vendor-js', function() {
  gulp.src(paths.unishopVendorJSSource)
  .pipe(ignore('modernizr.min.js'))
  .pipe(order([
    "vendor.min.js",
    "card.min.js"
  ]))
  .pipe(concat('unishop.vendor.min.js'))
  .pipe(gulp.dest(paths.jsDest));
  gulp.src('src/assets/js/unishop_js/vendor/bootstrap.min.js.map')
  .pipe(gulp.dest(paths.jsDest));
  var stream = gulp.src(paths.unishopVendorJSSource)
  .pipe(ignore(['card.min.js', 'vendor.min.js']))
  .pipe(order([
    "modernizr.min.js"
  ]))
  .pipe(gulp.dest(paths.jsDest));
  return stream;
});

gulp.task('compress-unishop-header-js', function() {
  var stream = gulp.src(paths.unishopVendorHeaderJSSource)
  .pipe(order([
    "jquery.js",
    "jquery-ui.js",
    "modernizr.min.js",
    // "jquery.timepicker.js",
    // "bootstrap-datepicker.js",
    // "site.js",
  ]))
  .pipe(concat('unishop.vendor.header.js'))
  .pipe(gulp.dest(paths.jsDest));
  return stream;
});

gulp.task('compress-unishop-footer-js', function() {
  var stream = gulp.src(paths.unishopVendorFooterJSSource)
  .pipe(order([
    "vendor.min.js",
    "card.min.js",


    "jquery-ui.js",
    "jquery.timepicker.js",
    "bootstrap-datepicker.js",
    "site.js"
  ]))
  .pipe(concat('unishop.vendor.footer.js'))
  .pipe(gulp.dest(paths.jsDest));
  return stream;
});

gulp.task('publish-unishop-fonts', function() {
  var stream = gulp.src(paths.unishopFontsSource)
  .pipe(gulp.dest(paths.fontsDest));
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
  .pipe(order([
    'bootstrap.css',
    'bootstrap-datetimepicker.min.css',
    '*.css'
  ]))
  .pipe(minify())
  .pipe(concat('admin_vendor_style.css'))
  .pipe(gulp.dest(paths.cssDest));
  return stream;
});

gulp.task('publish-dashgum-custom-js', function() {
  var stream = gulp.src(paths.dashgumCustomJSSource)
  .pipe(gulp.dest(paths.jsDest));
  return stream;
});

gulp.task('compress-dashgum-footer-js', function() {
  var stream = gulp.src(paths.dashgumFooterJSSource)
  .pipe(order([
    'fullcalendar.min.js',
    'jquery.fancybox.js',
    'jquery.dcjqaccordion.2.7.js',
    'jquery.scrollTo.min.js',
    'jquery.nicescroll.js',
    'jquery.sparkline.js',
    'bootstrap-datepicker.js',
    // 'date.js',
    'daterangepicker.js',
    'bootstrap-inputmask.min.js',
    'form-component.js',
    'common-scripts.js',
    'gritter-conf.js',
    'calendar-conf-events.js',
    'jquery-ui.js',
    'tasks.js',
    'jquery-ui-1.9.2.custom.min.js',
    'jquery.ui.touch-punch.min.js',
    'bootstrap-switch.js',
    'jquery.tagsinput.js',
    'jquery.transinput.js',
    'daterangepicker.js',
    'jquery.backstretch.min.js',
    'raphael-min.js',
    'morris.min.js',
    'morris-conf.js',
    'Chart.js',
    'chartjs-conf.js',
    'easy-pie-chart.js',
    'sparkline-chart.js',
    'zabuto_calendar.js',
    'jquery.gritter.js'
  ]))
  .pipe(concat('admin_footer.js'))
  .pipe(gulp.dest(paths.jsDest));
  return stream;
});

gulp.task('publish-dashgum-images', function() {
  var stream = gulp.src(paths.dashgumImgSorce)
  .pipe(gulp.dest(paths.imageDest));
  return stream;
});

gulp.task('compress-dashgum-header-js', function() {
  var stream = gulp.src(paths.dashgumHeaderJSSource)
  .pipe(order([
    "tether.js",
    "jquery.min.js",
    "moment.min.js",
    "bootstrap.min.js",
    "bootstrap-datetimepicker.min.js",
    "Chart.js"
  ]))
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

  var stream = gulp.src(mainBowerFiles())
  .pipe(jsFilter)
  .pipe(gulp.dest(paths.vendorJSDest))
  .pipe(jsFilter.restore);
  return stream;
});

gulp.task('push-bowercomponents-to-assets', function() {
  var jsFilter = gulpFilter('**/*.js', {restore: true});
  var cssFilter = gulpFilter('**/*.css', {restore: true});

  var stream = gulp.src(mainBowerFiles({
    includeDev: true,
    overrides: {
      'bootstrap': {
        main: [
          './dist/*/bootstrap.css',
          './dist/*/bootstrap.js',
          './dist/fonts/*'
        ]
      },
    }
  }))
  .pipe(jsFilter)
  .pipe(uglify())
  .pipe(gulp.dest('./assets/vendor/js'))
  .pipe(jsFilter.restore)

  .pipe(cssFilter)
  .pipe(gulp.dest('./assets/vendor/css'))
  .pipe(cssFilter.restore);
  return stream;
});

gulp.task('compress-bower-js', ['push-bowercomponents-to-assets'], function() {
  var stream = gulp.src('./assets/vendor/js/*.js')
  .pipe(order([
    'tether.js',
    'jquery.js',
    'bootstrap.js',
    'moment.js',
    '*.js'
  ]))
  .pipe(concat('admin_bower_vendor.js'))
  .pipe(gulp.dest(paths.jsDest));
  return stream;
});

gulp.task('compress-bower-css', ['push-bowercomponents-to-assets'], function() {
  var stream = gulp.src('./assets/vendor/css/*.css')
  .pipe(order([
    'bootstrap.css',
    '*.css'
  ]))
  .pipe(concat('admin_bower_vendor.css'))
  .pipe(gulp.dest(paths.cssDest));
  return stream;
});

gulp.task('process-bower-components', ['compress-bower-js', 'compress-bower-css'], function() {
  var stream = del('./assets/vendor/');
  return stream;
});
