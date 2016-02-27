angular.module('git-exercises', [
  'ipCookie'
  'ui.bootstrap.alert'
  'ui.bootstrap.progressbar'
  'ui.bootstrap.tpls'
  'ui.router'
])
.run (ExerciseService, $rootScope, CurrentCommiter) ->
  ExerciseService.getAll().then (exercises) ->
    $rootScope.availableExercises = exercises
