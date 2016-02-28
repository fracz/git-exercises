angular.module('git-exercises').controller 'CommitterDetailsController', ($scope, $stateParams, CurrentCommitter, $interval) ->
  $scope.committerEmail = $stateParams.email
  $scope.you =
    email: $stateParams.email

  CurrentCommitter.set($stateParams.id)

  getDetails = ->
    CurrentCommitter.fetchData().then (response) ->
      $scope.committerData = response

  getDetails()

  stop = $interval(getDetails, 6000)

  $scope.$on('$destroy', -> $interval.cancel(stop))
