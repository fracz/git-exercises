angular.module('git-exercises').directive 'exerciseContent', ($http, $state, $sce) ->
  templateUrl: 'exercise/exercise-content.html'
  scope:
    exercise: '=exerciseContent'
    hideCommand: '='
    heading: '@'
    committerId: '='
  link: ($scope) ->

    $scope.$watch 'exercise', ->
      $http.get('/api/exercise/' + $scope.exercise, cache: yes).success (exerciseData) ->
        $state.go('exercise', {}, location: 'replace') if not exerciseData?.readme
        exerciseData.readme = $sce.trustAsHtml(exerciseData.readme)
        exerciseData.summary = $sce.trustAsHtml(exerciseData.summary) if exerciseData.summary
        exerciseData.hint = $sce.trustAsHtml(exerciseData.hint) if exerciseData.hint
        $scope.exerciseData = exerciseData

    $scope.isMe = not $scope.committerId or $scope.committerId is $scope.$root.currentCommitter.id
