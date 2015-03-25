var gulp = require('gulp')
	, replace = require('gulp-replace')
	, concat = require('gulp-concat')
	, less = require('gulp-less')
	, minifyCSS = require('gulp-minify-css')
	, templateCache = require('gulp-angular-templatecache')
	, runSequence = require('run-sequence')
	, crypto = require("crypto");

/**
 * Файлы в порядке конкатенации
 * @type {string[]}
 */
var jsFiles = [

	// libs
	'./bower_components/jquery/dist/jquery.js'
	, './bower_components/underscore/underscore.js'

	// angular.js and its components
	, './bower_components/angular/angular.js'
	, './bower_components/angular-route/angular-route.js'
	, './bower_components/angular-resource/angular-resource.js'
	, './bower_components/ngstorage/ngStorage.js'

	// my application components
	, 'app/app.js'
	, 'app/_all-templates.js'  // Скомпилированные в angular-template-cache шаблоны
	, 'app/chat/**/*.js'
];

var ts = (new Date()).getTime().toString();

gulp.task('concat-js', function() {
	// place code for your default task here
	return gulp.src(jsFiles)
		.pipe(concat({ path: 'main.js'}))
		.pipe(gulp.dest('../../web/static/js-app/'));
});

gulp.task('styles', function() {
	gulp.src('./less/main.less')
		.pipe(less())
		.pipe(minifyCSS())
		.pipe(gulp.dest('../../web/static/css/'));
});

gulp.task('update-build-timestamp', function() {
	gulp.src('./_staticFileBuildTs.php')
		.pipe(replace('@@build-timestamp', function() { return ts; }))
		.pipe(gulp.dest('../../views/layouts/'));
});

gulp.task('js', function() {
	// 1. Собираем кэш шаблонов ангулара
	// 2. Склеиваем все js вместе
	// 3. Обновляем timestamp билда
	runSequence('ng-template', 'concat-js', 'update-build-timestamp');
});

gulp.task('css', function() {
	runSequence('styles', 'update-build-timestamp');
});

// @link https://github.com/miickel/gulp-angular-templatecache
gulp.task('ng-template', function () {
	gulp.src('app/**/*.html')
		.pipe(templateCache('_all-templates.js', {
			//standalone: true
		}))
		.pipe(gulp.dest('app/'));
});

gulp.task('watch', function() {
	runSequence('js', 'css');
	gulp.watch('app/**/*', ['js'])
		.on('change', function (event) {
			console.log('Event type: ' + event.type);
		});
	gulp.watch('less/**/*', ['css']);

});