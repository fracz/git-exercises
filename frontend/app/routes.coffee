angular.module('git-exercises').config ($urlRouterProvider, $stateProvider, $locationProvider, $urlMatcherFactoryProvider) ->
  $locationProvider.html5Mode(true)
  $urlMatcherFactoryProvider.defaultSquashPolicy(true)

  $urlRouterProvider.when('', '/')
  $urlRouterProvider.when('/index.html', '/')
  $urlRouterProvider.when('/!', '/') # for crawlers
  $urlRouterProvider.when('/exercise', '/exercise/master')
  $urlRouterProvider.when(/\/e\/([a-z\-]+)\/([a-z0-9]+)/, ($match) -> "/exercise/#{$match[1]}/#{$match[2]}")
  $urlRouterProvider.when(/\/e\/([a-z\-]+)/, '/exercise/$1')
  $urlRouterProvider.when(/\/c\/([a-z0-9]+)/, '/committer/$1')

  $urlRouterProvider.otherwise ($injector, $location) ->
    $state = $injector.get('$state')
    $state.go('notFound')
    $location.path()

  $stateProvider
  .state 'home',
    url: '/'
    templateUrl: 'home/home.html'
    metaTags: {}

  .state 'committer',
    url: '/committer/{id}?{email}&{name}&{remember:bool}'
    controller: 'CommitterDetailsController'
    templateUrl: 'committer/committer.html'
    params:
      remember: yes
    metaTags:
      title: 'My progress'
      prerender:
        statusCode: 404

  .state 'exercise',
    url: '/exercise'
    controller: 'ExerciseListController'
    templateUrl: 'exercise/exercise-list.html'
    metaTags: {}

  .state 'exercise.details',
    url: '/{id}'
    controller: 'ExerciseDetailsController'
    templateUrl: 'exercise/exercise-details.html'
    metaTags:
      title: ($stateParams) ->
        'ngInject'
        $stateParams.id

  .state 'exercise.detailsWithCommitter',
    url: '/{id}/{committerId}'
    controller: 'ExerciseDetailsController'
    templateUrl: 'exercise/exercise-details.html'
    onEnter: ($stateParams, CurrentCommitter) ->
      CurrentCommitter.set($stateParams.committerId)
    metaTags:
      title: ($stateParams) ->
        'ngInject'
        $stateParams.id
      prerender:
        statusCode: 404

  .state 'faq',
    url: '/faq'
    templateUrl: 'static/faq.html'
    metaTags:
      title: 'FAQ'

  .state 'gamification',
    url: '/gamification'
    template: '<result-board></result-board>'
    metaTags:
      title: 'Gamification'

  .state 'cheatsheet',
    url: '/cheatsheet'
    templateUrl: 'static/cheatsheet.html'
    metaTags:
      title: 'Cheatsheet'

  .state 'notFound',
    templateUrl: 'static/404.html'
    metaTags:
      title: 'Page not found'
      prerender:
        statusCode: 404
