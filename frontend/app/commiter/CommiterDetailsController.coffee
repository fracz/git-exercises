angular.module('git-exercises').controller 'CommiterDetailsController', ($scope, $stateParams, CurrentCommiter, $interval) ->
  $scope.commiterEmail = $stateParams.email
  $scope.you =
    email: $stateParams.email

  CurrentCommiter.set($stateParams.id)

  getDetails = ->
    CurrentCommiter.fetchData().then (response) ->
      $scope.commiterData = response

  getDetails()

  stop = $interval(getDetails, 5000)

  $scope.$on('destroy', -> $interval.cancel(stop))
