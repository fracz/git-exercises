angular.module('git-exercises').directive 'passedIcon', (containsFilter) ->
  template: '<span ng-if="passed" attempt-result-icon="{is_passed: true}"></span>'
  scope: yes
  link: ($scope) ->
    $scope.passed = containsFilter($scope.$root.currentCommiter?.passedExercises, $scope.exercise)
