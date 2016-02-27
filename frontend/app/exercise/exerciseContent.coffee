angular.module('git-exercises').directive 'exerciseContent', ($http, $state, $sce, CurrentCommiter) ->
  templateUrl: 'exercise/exercise-content.html'
  scope:
    exercise: '=exerciseContent'
    hideCommand: '='
    heading: '@'
  link: ($scope) ->

    $scope.$watch 'exercise', ->
      $http.get('/api/exercise/' + $scope.exercise, cache: yes).success (exerciseData) ->
        $state.go('exercise', {}, location: 'replace') if not exerciseData?.readme
        exerciseData.readme = $sce.trustAsHtml(exerciseData.readme)
        exerciseData.summary = $sce.trustAsHtml(exerciseData.summary) if exerciseData.summary
        $scope.exerciseData = exerciseData

    CurrentCommiter.getData() if not $scope.$root.currentCommiter?.passedExercises
