var gulp 			= require('gulp'),
	autoprefixer 	= require('gulp-autoprefixer'),
	minifycss 		= require('gulp-minify-css'),
    uglify 			= require('gulp-uglify'),
    imagemin 		= require('gulp-imagemin'),
    rename 			= require('gulp-rename'),
    clean 			= require('gulp-clean'),
    concat 			= require('gulp-concat'),
    notify 			= require('gulp-notify'),
    cache 			= require('gulp-cache'),
    livereload 		= require('gulp-livereload');

gulp.task('styles', function() {
  return gulp.src('assets/css/**/*.css')
    .pipe(concat('main.css'))
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

gulp.task('default', ['clean'], function() {
    gulp.start('styles', 'scripts', 'images');
});

gulp.task('watch', function() {

  var server = livereload();

  // Watch any files in dist/, reload on change
  gulp.watch(['assets/dist/**']).on('change', function(file) {
    server.changed(file.path);
  });
  // Watch .scss files
  gulp.watch('assets/css/**/*.css', ['styles']);

  // Watch .js files
  gulp.watch('assets/js/**/*.js', ['scripts']);

  // Watch image files
  gulp.watch('assets/img/**/*', ['images']);

});