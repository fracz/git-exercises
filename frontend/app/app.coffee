angular.module('git-exercises', [
  'angular-clipboard'
  'ipCookie'
  'ui.bootstrap.alert'
  'ui.bootstrap.progressbar'
  'ui.bootstrap.tpls'
  'ui.router'
])
.run (ExerciseService, $rootScope, CurrentCommitter) ->
  ExerciseService.getAll().then (exercises) ->
    $rootScope.availableExercises = exercises
