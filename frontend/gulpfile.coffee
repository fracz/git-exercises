gulp = require('gulp')
$ = require('gulp-load-plugins')();
argv = require('yargs').argv
process.env.NODE_ENV = if argv.production then 'production' else 'development'

del = require('del')
runSequence = require('run-sequence')
bowerFiles = require("main-bower-files")

appVersion =
  number: '0.0'
  build: 'unknown'

htmlMinifier = ->
  $.minifyHtml
    empty: yes
    loose: yes
    quotes: yes

gulp.task 'bowerdeps', ->
  vendor = gulp.src(bowerFiles(), base: 'bower_components')
  if argv.production
    jsFilter = $.filter('**/*.js')
    cssFilter = $.filter('**/*.css')
    vendor = vendor
    .pipe(jsFilter)
    .pipe($.concat('vendor.js'))
    .pipe(jsFilter.restore())
    .pipe(cssFilter)
    .pipe($.concatCss('vendor.css'))
    .pipe($.minifyCss())
    .pipe(cssFilter.restore())
  vendor.pipe(gulp.dest('public/libs'))

gulp.task 'styles', ->
  gulp.src('app/css/style.scss')
  .pipe $.sass
    outputStyle: 'nested'
    onError: (error) ->
      $.util.log("SASS: #{error.message} at line #{error.line} column #{error.column} in #{error.file}")
  .pipe($.if(argv.production, $.minifyCss()))
  .pipe(gulp.dest("public"))

gulp.task 'indexView', ->
  appFiles = [
    'public/app.js'
    'public/style.css'
  ]
  if argv.production
#    appFiles.shift()
    appFiles.unshift('public/libs/vendor.css')
    appFiles.push('public/templates.js')
  gulp.src('app/index.html')
  .pipe $.if not argv.production, $.inject gulp.src(bowerFiles(), read: false),
    name: 'bower'
    addRootSlash: no
    ignorePath: '/bower_components/'
    addPrefix: '/libs'
  .pipe $.inject gulp.src(appFiles, read: false),
    name: 'app'
    ignorePath: 'public'
  .pipe($.if(argv.production, htmlMinifier()))
  .pipe($.if(argv.production, $.replace(/\.((css)|(js))/g, '.$1?' + appVersion.build)))
  .pipe(gulp.dest('public'))

gulp.task 'views', ->
  views = gulp.src('app/*/**/*.html')
  if argv.production
    views = views
    .pipe(htmlMinifier())
    .pipe $.angularTemplatecache
      module: 'git-exercises'
  views.pipe(gulp.dest('public'))

gulp.task 'scripts', ->
  coffeeStream = $.coffee(bare: yes)
  if not argv.production
    coffeeStream.on 'error', (error) ->
      $.util.log(error)
      coffeeStream.end()
  gulp.src('app/**/*.coffee')
  .pipe(coffeeStream)
  .pipe($.angularFilesort())
  .pipe($.ngAnnotate())
  .pipe($.concat('app.js'))
  .pipe(gulp.dest('public'))
  .on 'end', ->
    if argv.production
      gulp.src(['public/libs/vendor.js', 'public/app.js'])
      .pipe($.concat('app.js'))
      .pipe($.uglify())
      .pipe(gulp.dest('public'))

gulp.task 'clean', (done) ->
  del [
      'public/*'
      '!public/.gitignore'
      '!public/.htaccess*'
      '!public/api.php'
    ]
  ,
    done

gulp.task 'default', (done) ->
  runSequence 'clean', 'bowerdeps', 'scripts', 'styles', 'views', 'indexView', done

gulp.task 'watch', (done) ->
  runSequence 'clean', 'default', ->
    gulp.watch('app/**/*.coffee', ['scripts'])
    gulp.watch('app/*/**/*.html', ['views'])
    gulp.watch('app/index.html', ['indexView'])
    gulp.watch('app/css/style.scss', ['styles'])
    done()
