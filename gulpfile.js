var gulp         = require('gulp'),
    autoprefixer = require('gulp-autoprefixer'),
    sass		     = require('gulp-sass'),
    minifycss    = require('gulp-minify-css'),
    uglify       = require('gulp-uglify'),
    imagemin     = require('gulp-imagemin'),
    rename       = require('gulp-rename'),
    clean        = require('gulp-clean'),
    concat       = require('gulp-concat'),
    notify       = require('gulp-notify'),
    cache        = require('gulp-cache'),
    chmod        = require('gulp-chmod'),
    livereload   = require('gulp-livereload');

gulp.task('styles', function() {
  return gulp.src('assets/sass/style.scss')
    .pipe(sass())
    .pipe(gulp.dest('assets/dist/css'))
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(gulp.dest('assets/dist/css'))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifycss())
    .pipe(gulp.dest('assets/dist/css'))
    .pipe(notify({ message: 'Styles task complete' }));
});

gulp.task('scripts', function() {
  return gulp.src('assets/js/**/*.js')
    .pipe(concat('main.js'))
    .pipe(gulp.dest('assets/dist/js'))
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(gulp.dest('assets/dist/js'))
    .pipe(notify({ message: 'Scripts task complete' }));
});

gulp.task('images', function() {
  return gulp.src('assets/img/**/*')
    .pipe(cache(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true })))
    .pipe(gulp.dest('assets/dist/img'))
    .pipe(notify({ message: 'Images task complete' }));
});

gulp.task('clean', function() {
  return gulp.src(['assets/dist'], {read: false})
    .pipe(clean());
});

gulp.task('clearcache', function() {
  return gulp.src(['cockpit/storage/cache/assets/**/*', 'cockpit/storage/cache/thumbs/**/*', 'cockpit/storage/cache/tmp/**/*'], {read: false})
    .pipe(clean());
});
gulp.task('copydb', function() {
  return gulp.src(['cockpit/storage/data/**', '!cockpit/storage/data/cockpit.sqlite'])
    .pipe(chmod(666))
    .pipe(gulp.dest('test/assets'))
    .pipe(notify({ message: 'DB copy task complete' }));
});


gulp.task('default', ['clean'], function() {
    gulp.start('clearcache','styles', 'scripts', 'images');
});

gulp.task('watch', function() {

  var server = livereload();

  // Watch any files in dist/, reload on change
  gulp.watch(['assets/dist/**']).on('change', function(file) {
    server.changed(file.path);
  });
  // Watch .less files
  gulp.watch('assets/sass/**/*.scss', ['styles']);

  // Watch .js files
  gulp.watch('assets/js/**/*.js', ['scripts']);

  // Watch image files
  gulp.watch('assets/img/**/*', ['images']);

  // Watch views
  gulp.watch('assets/views/**/*', ['clearcache']);
  gulp.watch('cockpit/storage/data/**/*', ['copydb', 'clearcache']);

});