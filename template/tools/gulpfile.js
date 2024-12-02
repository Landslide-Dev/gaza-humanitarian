// Load Gulp yo!
var gulp    = require('gulp'),
    plugins = require('gulp-load-plugins')();

// Start Watching: Run "gulp"
gulp.task('default', ['watch']);

// Minify jQuery Plugins: Run manually with: "gulp squish-plugins"
gulp.task('squish-plugins', function() {
    return gulp.src('../js/plugins/**/*.js')
        /*
        * Uncomment this if you want to lint js plugins.
        * Not all plugins are perfect and will probably
        * throw tons of warnings depending on
        * how jQuery plugin crazy you are...

        .pipe(plugins.plumber())
        .pipe(plugins.jshint())
        .pipe(plugins.jshint.reporter('jshint-stylish'))
        .on('error', function (err) {
            plugins.util.log(err);
            this.emit('end');
        })

        */
        .pipe(plugins.concat('plugins.js'))
        .pipe(gulp.dest('../js'))
        .pipe(plugins.uglify())
        .pipe(plugins.concat('plugins.min.js'))
        .pipe(gulp.dest('../js'));
});

// Minify Custom JS: Run manually with: "gulp build-js"
gulp.task('build-js', function() {
    return gulp.src('../js/scripts/**/*.js')
        .pipe(plugins.plumber())
        .pipe(plugins.jshint())
        .pipe(plugins.jshint.reporter('jshint-stylish'))
        .on('error', function (err) {
            plugins.util.log(err);
            this.emit('end');
        })
        .pipe(plugins.concat('scripts.js'))
        .pipe(gulp.dest('../js'))
        .pipe(plugins.uglify())
        .pipe(plugins.concat('scripts.min.js'))
        .pipe(gulp.dest('../js'));
});

// Less to CSS: Run manually with: "gulp build-css"
gulp.task('build-css', function() {

    return gulp.src('../less/*.less')
        .pipe(plugins.plumber())
        .pipe(plugins.less())
        .on('error', function (err) {
            plugins.util.log(err);
            this.emit('end');
        })
        .pipe(plugins.autoprefixer(
            {
                browsers: [
                    '> 1%',
                    'last 2 versions',
                    'firefox >= 4',
                    'safari 7',
                    'safari 8',
                    'IE 8',
                    'IE 9',
                    'IE 10',
                    'IE 11'
                ],
                cascade: false
            }
        ))
        .pipe(plugins.cssmin())
        .pipe(plugins.header(
            [''].join('\n')
        ))
        .pipe(gulp.dest('../.')).on('error', plugins.util.log);
});

// Default task
gulp.task('watch', function() {
    gulp.watch('../js/plugins/**/*.js', ['squish-plugins']);
    gulp.watch('../js/scripts/**/*.js', ['build-js']);
    gulp.watch('../less/**/*.less', ['build-css']);
});