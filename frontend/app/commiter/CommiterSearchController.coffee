angular.module('git-exercises').controller 'CommiterSearchController', ($scope, $state) ->
  $scope.search = ->
    if $scope.commiterEmail
      $state.go('commiter', {id: sha1($scope.commiterEmail), email: $scope.commiterEmail})
