angular.module('git-exercises').directive 'exerciseHint', ->
  scope:
    exercise: '=exerciseHint'
    hint: '='
  templateUrl: 'exercise/exercise-hint.html'
  link: ($scope) ->
    attemptOldEnoughForHint = (latest) ->
      moment(latest.timestamp).add(5, 'minute').isBefore(moment())

    $scope.displayHint = ->
      latest = $scope.$root.currentCommitter?.attempts?[0]
      latest?.timestamp and (latest.exercise is $scope.exercise or attemptOldEnoughForHint(latest))
