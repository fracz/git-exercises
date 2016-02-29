angular.module('git-exercises').controller 'CommitterDetailsController', ($scope, $stateParams, CurrentCommitter, $interval) ->
  $scope.committerEmail = $stateParams.email
  $scope.you =
    email: $stateParams.email
    name: $stateParams.name

  $scope.committerId = $stateParams.id

  CurrentCommitter.set($stateParams.id) if $stateParams.remember

  getDetails = ->
    CurrentCommitter.fetchData($stateParams.id).then (response) ->
      $scope.committerData = response

  getDetails()

  stop = $interval(getDetails, 6000)

  $scope.$on('$destroy', -> $interval.cancel(stop))
