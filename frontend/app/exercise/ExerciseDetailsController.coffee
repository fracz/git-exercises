angular.module('git-exercises').controller 'ExerciseDetailsController', ($scope, $http, $state, $stateParams) ->
  $scope.exercise = $stateParams.id
