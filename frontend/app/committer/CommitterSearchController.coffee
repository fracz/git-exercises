angular.module('git-exercises').controller 'CommitterSearchController', ($scope, $state) ->
  $scope.search = ->
    if $scope.committerEmail
      $state.go('committer', {id: sha1($scope.committerEmail), email: $scope.committerEmail})
