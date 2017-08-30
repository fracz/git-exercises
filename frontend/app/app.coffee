angular.module('git-exercises', [
  'angular-clipboard'
  'ipCookie'
  'ui.bootstrap.alert'
  'ui.bootstrap.progressbar'
  'ui.bootstrap.tpls'
  'ui.router'
  'ui.router.metatags'
])
.run (ExerciseService, $rootScope, CurrentCommitter) ->
  ExerciseService.getAll().then (exercises) ->
    $rootScope.availableExercises = exercises
.run ($rootScope, MetaTags) ->
  $rootScope.MetaTags = MetaTags
.run ($rootScope, $window, $location) ->
  $rootScope.$on '$stateChangeSuccess', ->
    $window.ga?('send', 'pageview', page: $location.url())
.config (UIRouterMetatagsProvider) ->
  UIRouterMetatagsProvider
  .setTitleSuffix(' - Git Exercises')
  .setDefaultTitle('Git Exercises')
.run ($http) -> # synchronize browser time with server's
  requestStartTime = Date.now()
  $http.get('/api/time').success (serverTime) ->
    requestTime = Date.now() - requestStartTime
    offset = new Date(serverTime).getTime() - Date.now() + requestTime
    moment.now = -> Date.now() + offset
