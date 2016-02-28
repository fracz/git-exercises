angular.module('git-exercises').config ($urlRouterProvider, $stateProvider, $locationProvider) ->
  $locationProvider.html5Mode(true)
  $urlRouterProvider.when('', '/')
  $urlRouterProvider.when('/!', '/') # for crawlers
  $urlRouterProvider.when('/exercise', '/exercise/master')
  $urlRouterProvider.when(/\/e\/([a-z\-]+)\/([a-z0-9]+)/, ($match) -> "/exercise/#{$match[1]}/#{$match[2]}")
  $urlRouterProvider.when(/\/e\/([a-z\-]+)/, '/exercise/$1')
  $urlRouterProvider.when(/\/c\/([a-z0-9]+)/, '/committer/$1')

  #  $urlRouterProvider.otherwise('/')

  $stateProvider
  .state 'home',
    url: '/'
    controller: 'HomeController'
    templateUrl: 'home/home.html'

  .state 'committer',
    url: '/committer/{id}?{email}'
    controller: 'CommitterDetailsController'
    templateUrl: 'committer/committer.html'

  .state 'exercise',
    url: '/exercise'
    controller: 'ExerciseListController'
    templateUrl: 'exercise/exercise-list.html'

  .state 'exercise.details',
    url: '/{id}'
    controller: 'ExerciseDetailsController'
    templateUrl: 'exercise/exercise-details.html'

  .state 'exercise.detailsWithCommitter',
    url: '/{id}/{committerId}'
    controller: 'ExerciseDetailsController'
    templateUrl: 'exercise/exercise-details.html'
    onEnter: ($stateParams, CurrentCommitter) ->
      CurrentCommitter.set($stateParams.committerId)

  .state 'faq',
    url: '/faq'
    templateUrl: 'static/faq.html'

  .state 'cheatsheet',
    url: '/cheatsheet'
    templateUrl: 'static/cheatsheet.html'
