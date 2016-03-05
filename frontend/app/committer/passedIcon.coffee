angular.module('git-exercises').directive 'passedIcon', ->
  template: '<span ng-if="$root.currentCommitter.passedExercises | contains:exercise" attempt-result-icon="{is_passed: true}"></span>'
  scope: no
