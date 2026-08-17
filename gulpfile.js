const gulp          = require("gulp"),
    path          = require("path"),
    postcss       = require("gulp-postcss"),
    browserSync   = require('browser-sync').create(),
    sourcemaps    = require('gulp-sourcemaps'),
    cssnano       = require('cssnano'),
    uglify        = require('gulp-uglify'),
    browserify    = require('browserify'),
    babelify      = require('babelify'),
    source        = require('vinyl-source-stream'),
    buffer        = require('vinyl-buffer'),
    uglifyEs      = require('gulp-uglify-es').default,
    CSSFILES      = [ 'main', 'font-awesome' ],
    JSFILES       = [ 'main', 'shop' ];
    COMPONENT_JSFILES = [ 'searchbar', 'dropdown', 'withrawal' ];

JSFILES.forEach( (js) => {
    gulp.task( `dev:js-${js}`, () => {
        const bundler = browserify(`src/scripts/${js}.js`, {
            debug: true
        });

        bundler.transform(babelify.configure({
            presets: [['@babel/preset-env', {
                        "forceAllTransforms": true,
                        "spec": true,
                        "loose": true
                    }]
            ]
        }));

        return bundler.bundle()
        .pipe(source(`${js}.js`))
        .pipe(buffer())
        .pipe(uglifyEs())
        .pipe(gulp.dest('assets/scripts'))
        .pipe(browserSync.stream());

    } )
} );

COMPONENT_JSFILES.forEach( (js) => {
    gulp.task( `dev:js-${js}-component`, () => {
        const bundler = browserify(`src/scripts/components/${js}.js`, {
            debug: true
        });

        bundler.transform(babelify.configure({
            presets: [['@babel/preset-env', {
                        "forceAllTransforms": true,
                        "spec": true,
                        "loose": true
                    }]
            ]
        }));

        return bundler.bundle()
        .pipe(source(`${js}.js`))
        .pipe(buffer())
        .pipe(uglifyEs())
        .pipe(gulp.dest('assets/scripts/components'))
        .pipe(browserSync.stream());

    } )
} );

CSSFILES.forEach( (css) => {
    gulp.task( `dev:css-${css}`, () => {
        return gulp.src( `src/styles/${css}.css` )
        .pipe(sourcemaps.init())
        .pipe(postcss([
            require('autoprefixer'),
            cssnano(),
        ]))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest("assets/styles"))
        .pipe(browserSync.stream());

    } )
} );



gulp.task('default' , () => {
    const watchJSFiles = [ 'src/scripts/**/*.js' ];
    const watchCSSFiles = [ 'src/styles/**/*.css' ];

    JSFILES.forEach( (js) => {
        gulp.watch( watchJSFiles , gulp.parallel( `dev:js-${js}` ) );
    } );

    COMPONENT_JSFILES.forEach( (js) => {
        gulp.watch( watchJSFiles , gulp.parallel( `dev:js-${js}-component` ) );
    } );
    
    CSSFILES.forEach( (css) => {
        gulp.watch( watchCSSFiles , gulp.parallel( `dev:css-${css}` ) );
    } );
} );