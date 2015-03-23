var gulp = require('gulp')
	, concat = require('gulp-concat')
	, clean = require('gulp-clean')
	, runSequence = require('run-sequence')
	, crypto = require("crypto");

/**
 * Файлы в порядке конкатенации
 * @type {string[]}
 */
var jsFiles = [
	'./bower_components/jquery/dist/jquery.js'
	, './bower_components/angular/angular.js'
	, './bower_components/underscore/underscore.js'
	, 'app/app.js'
];

/**
 * Имя сгенерированного js файла
 * @type {string}
 */
var mainJsFile = crypto.createHash("md5")
		.update((new Date()).getTime().toString())
		.digest("hex")
		.substring(1, 8) + '.all.js';


gulp.task('concat', function() {
	// place code for your default task here
	return gulp.src(jsFiles)
		.pipe(concat({ path: mainJsFile}))
		.pipe(gulp.dest('./_build/js-app'));
});

gulp.task('copy', function() {
	return gulp
		.src('./_build/**/*')
		.pipe(gulp.dest('../../web/static/'));
});

gulp.task('clean-tmp', function() {
	return gulp.src('./_build/js-app', {read: false})
		.pipe(clean());
});

gulp.task('clean-prod', function() {
	return gulp.src('../../web/static/', {read: false})
		.pipe(clean({force: true}));
});

gulp.task('default', function() {
	runSequence('clean-tmp', 'concat', 'clean-prod', 'copy');
});