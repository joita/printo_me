var	gulp 			= require('gulp'),
	concat 			= require('gulp-concat'),
	deporder		= require('gulp-deporder'),
	stripdebug 		= require('gulp-strip-debug'),
	uglify 			= require('gulp-uglify'),
	folder			= {
		src: 'assets/',
		bower: 'bower_components/',
		build: 'js/'
	},
	$ 		= require('gulp-load-plugins')(),
	sassPaths = [
		'bower_components/foundation-sites/scss',
		'bower_components/motion-ui/src'
	]
;

gulp.task('sass', function() {
  return gulp.src('scss/*.scss')
    .pipe($.sass({
      includePaths: sassPaths,
      outputStyle: 'compressed'
    })
      .on('error', $.sass.logError))
    .pipe($.autoprefixer({
      browsers: ['last 2 versions', 'ie >= 9']
    }))
    .pipe(gulp.dest('css'));
});

gulp.task('sass2', function() {
  return gulp.src('scss_2/*.scss')
    .pipe($.sass({
      includePaths: sassPaths,
      outputStyle: 'compressed'
    })
      .on('error', $.sass.logError))
    .pipe($.autoprefixer({
      browsers: ['last 2 versions', 'ie >= 9']
    }))
    .pipe(gulp.dest('css_2'));
});

gulp.task('design_css', function() {
	var desss = gulp.src([
		'assets/plugins/bootstrap/css/bootstrap.min.css',
		'assets/plugins/jquery-ui/jquery-ui.min.css',
		'css_2/app.css',
		'scss_2/_settings.scss',
		'scss_2/_mixins.scss',
		'scss_2/_walkthrough.scss',
		'scss_2/_personalizador.scss'
	]).pipe(concat('desbase.css'))
	.pipe($.sass({
		includePaths: sassPaths,
		outputStyle: 'compressed'
	}));

	return desss.pipe(gulp.dest('css_2'));
});

gulp.task('default', ['sass2', 'design_css', 'js', 'desjs'], function() {
  //gulp.watch(['scss/**/*.scss'], ['sass']);
  gulp.watch(['scss_2/**/*.scss'], ['sass2']);
  gulp.watch(['scss_2/**/*.scss'], ['design_css']);
  gulp.watch(['js/app.js', 'js/adicionales.js', folder.bower+'jquery-pagewalkthrough/dist/jquery.pagewalkthrough.js'], ['js']);
  gulp.watch(['js/appdes.js', 'assets/js/*js', folder.bower+'jquery-pagewalkthrough/dist/jquery.pagewalkthrough.js'], ['desjs']);
});

gulp.task('js', function() {
	var jsbuild = gulp.src([
		folder.bower+'jquery/dist/jquery.min.js',
		folder.bower+'what-input/what-input.min.js',
		folder.bower+'foundation-sites/dist/foundation.min.js',
		//folder.bower+'webfontloader/webfontloader.js',
		folder.bower+'pickadate/lib/compressed/picker.js',
		folder.bower+'pickadate/lib/compressed/picker.date.js',
		folder.bower+'pickadate/lib/compressed/legacy.js',
		folder.bower+'imagesloaded/imagesloaded.pkgd.min.js',
		folder.bower+'slick-carousel/slick/slick.min.js',
		folder.bower+'owl.carousel/dist/owl.carousel.min.js',
		//folder.bower+'elevatezoom/jquery.elevateZoom-3.0.8.min.js',
		folder.bower+'isotope/dist/isotope.pkgd.min.js',
		//folder.bower+'color-thief/dist/color-thief.min.js',
		folder.bower+'jquery_lazyload/jquery.lazyload.js',
		folder.bower+'jquery.payment/lib/jquery.payment.min.js',
		folder.bower+'moment/min/moment-with-locales.min.js',
		folder.bower+'moment-timezone/builds/moment-timezone-with-data-2012-2022.min.js',
		folder.bower+'jquery.countdown/dist/jquery.countdown.min.js',
		folder.bower+'teamdf/jquery-number/jquery.number.min.js',
		folder.bower+'jquery-unveil/jquery.unveil.min.js',
		folder.bower+'jquery-pagewalkthrough/dist/jquery.pagewalkthrough.js',
		folder.bower+'smooth-scroll/dist/js/smooth-scroll.min.js',
		folder.bower+'jquery-mousewheel/jquery.mousewheel.min.js',
		folder.bower+'hammerjs/hammer.min.js',
		folder.bower+'jquery-nice-select/js/jquery.nice-select.min.js',
		folder.bower+'jquery-bar-rating/dist/jquery.barrating.min.js',
		folder.bower+'jquery.tagsinput/src/jquery.tagsinput.js',
		folder.src+'js/TweenMax.min.js',
		folder.src+'js/pinchzoom/jquery.pinchzoomer.min.js',
		//folder.bower+'unitegallery/dist/js/unitegallery.min.js',
		//folder.bower+'unitegallery/dist/themes/tiles/ug-theme-tiles.js',
		folder.build+'adicionales.js',
		folder.build+'app.js'
	])
	.pipe(concat('main.js'))
	/* .pipe(uglify()); */;

	return jsbuild.pipe(gulp.dest(folder.build));
});

gulp.task('desjs', function() {
	var jsbuild = gulp.src([
		folder.bower+'jquery/dist/jquery.min.js',
		'assets/js/canvg.js',
		'assets/js/main.js',
		folder.bower+'what-input/what-input.min.js',
		folder.bower+'webfontloader/webfontloader.js',
		folder.bower+'foundation-sites/dist/foundation.min.js',
		//folder.bower+'color-thief/dist/color-thief.min.js',
		folder.bower+'jquery.payment/lib/jquery.payment.min.js',
		folder.bower+'pickadate/lib/compressed/picker.js',
		folder.bower+'pickadate/lib/compressed/picker.date.js',
		folder.bower+'jquery_lazyload/jquery.lazyload.js',
		folder.bower+'owl.carousel/dist/owl.carousel.min.js',
		folder.bower+'jquery-pagewalkthrough/dist/jquery.pagewalkthrough.js',
		folder.bower+'clipboard/dist/clipboard.min.js',
		'assets/plugins/jquery-ui/jquery-ui.min.js',
		'assets/plugins/bootstrap/js/bootstrap.min.js',
		'assets/js/add-ons.js',
		'assets/js/jquery.ui.rotatable.js',
		'assets/js/validate.js',
		'assets/js/language.js',
		'assets/js/design.js',
		'assets/js/design_upload.js',
		folder.build+'adicionalesdes.js',
		folder.build+'appdes.js',
	])
	.pipe(concat('maindes.js'))
	/*.pipe(uglify())*/;

	return jsbuild.pipe(gulp.dest(folder.build));
});
