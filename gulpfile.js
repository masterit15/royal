var gulp         = require('gulp'),
		sass         = require('gulp-sass'),
		autoprefixer = require('gulp-autoprefixer'),
		cleanCSS     = require('gulp-clean-css'),
		rename       = require('gulp-rename'),
		browserSync  = require('browser-sync').create(),
		concat       = require('gulp-concat'),
		uglify       = require('gulp-uglify-es').default;

gulp.task('browser-sync', function() {
	browserSync.init({
		proxy: "http://royal.rg:8080/"
	});
});
function bsReload(done) { browserSync.reload(); done() };

gulp.task('styles', function () {
	return gulp.src('sass/**/*.sass')
	.pipe(sass({
		outputStyle: 'expanded',
		includePaths: require('node-bourbon').includePaths
	}).on('error', sass.logError))
	.pipe(rename({suffix: '.min', prefix : ''}))
	.pipe(autoprefixer({
		// grid: true, // Optional. Enable CSS Grid
		overrideBrowserslist: ['last 10 versions']
	}))
	.pipe(cleanCSS())
	.pipe(gulp.dest('app/css'))
	.pipe(browserSync.stream());
});

gulp.task('scripts', function() {
	return gulp.src([
		// 'app/libs/modernizr/modernizr.js',
		'node_modules/jquery/dist/jquery.min.js',
		'app/libs/jquery-ui/jquery-ui.min.js',
		'node_modules/jquery-validation/dist/jquery.validate.min.js',
		'node_modules/jquery-validation/dist/localization/messages_ru.js',
		'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
		'app/libs/waypoints/waypoints.min.js',
		'app/libs/animate/animate-css.js',
		'app/libs/select2/js/select2.min.js',
		'app/libs/select2/js/i18n/ru.js',
		'node_modules/nprogress/nprogress.js',
		'node_modules/toastr/toastr.js',
		'node_modules/owl.carousel/docs/assets/owlcarousel/owl.carousel.min.js',
		'node_modules/gsap/dist/gsap.min.js',
		'node_modules/izimodal/js/iziModal.min.js',
		'node_modules/colorthief/dist/color-thief.min.js',
		'node_modules/wowjs/dist/wow.min.js',
		
		])
		.pipe(concat('libs.js'))
		.pipe(uglify()) //Minify libs.js
		.pipe(gulp.dest('app/js/'))
		.pipe(browserSync.reload({ stream: true }));
});

gulp.task('code', function() {
	return gulp.src('app/**/*.html')
	.pipe(browserSync.reload({ stream: true }))
});

gulp.task('watch', function () {
	gulp.watch('sass/**/*.sass', gulp.parallel('styles'));
	gulp.watch(['app/js/common.js', 'app/libs/**/*.js'], gulp.parallel('scripts'));
	gulp.watch('app/*.html', gulp.parallel('code'));
	gulp.watch("app/**/*.php").on("change", browserSync.reload);
});

gulp.task('default', gulp.parallel('styles', 'scripts', 'browser-sync', 'watch'));
