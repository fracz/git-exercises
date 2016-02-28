angular.module('git-exercises').config ($urlRouterProvider, $stateProvider, $locationProvider) ->
  $locationProvider.html5Mode(true)
  $urlRouterProvider.when('', '/')
  $urlRouterProvider.when('/exercise', '/exercise/master')

  $urlRouterProvider.otherwise('/')

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
