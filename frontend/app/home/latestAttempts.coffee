angular.module('git-exercises').directive 'latestAttempts', ($http, $interval) ->
  templateUrl: 'home/latest.html'
  scope:
    latest: '=latestAttempts'
  link: ($scope) ->
    fetchLatest = ->
      $http.get('/api/latest').success (response) ->
        $scope.latest = response

    if $scope.latest?.length > 0
      $scope.hideCommitterName = yes
    else
      fetchLatest()
      stop = $interval(fetchLatest, 10000)
      $scope.$on('destroy', -> $interval.cancel(stop))
