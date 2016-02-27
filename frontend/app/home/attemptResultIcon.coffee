angular.module('git-exercises').directive 'attemptResultIcon', ->
  template: '<span class="attempt-result-icon glyphicon" ng-class="iconClass"></span>'
  scope:
    attempt: '=attemptResultIcon'
  link: ($scope) ->
    if $scope.attempt.is_passed
      $scope.iconClass = 'glyphicon-ok text-success'
    else
      $scope.iconClass = 'glyphicon-remove text-danger'
