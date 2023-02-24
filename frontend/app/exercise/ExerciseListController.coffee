angular.module('git-exercises').controller 'ExerciseListController', ($scope, $http, ExerciseService) ->
  ExerciseService.getAll().then (exercises) ->
    $scope.exercises = exercises
