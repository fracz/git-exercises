angular.module('git-exercises').service 'GamificationService', ($http, $q) ->
  new class
    getResultBoard: ->
      $q.when([
        {committer_name: 'Jan Kowalski', failed: 3, passed: 2, points: 101.234}
        {committer_name: 'Jan Kowalski', failed: 3, passed: 2, points: 101.234}
        {committer_name: 'Jan Kowalski', failed: 3, passed: 2, points: 101.234}
        {committer_name: 'Jan Kowalski', failed: 3, passed: 2, points: 101.234}
        {committer_name: 'Jan Kowalski', failed: 3, passed: 2, points: 101.234}
        {committer_name: 'Jan Kowalski', failed: 3, passed: 2, points: 101.234}
        {committer_name: 'Jan Kowalski', failed: 3, passed: 2, points: 101.234}
      ])
#      $http.get('/api/gamification/current').then (response) ->
#        response.data
