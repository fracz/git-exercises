angular.module('git-exercises').directive 'passedIcon', (containsFilter) ->
  template: '<span ng-if="$root.currentCommiter.passedExercises | contains:exercise" attempt-result-icon="{is_passed: true}"></span>'
  scope: no
