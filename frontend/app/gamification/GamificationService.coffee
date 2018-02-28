angular.module('git-exercises').service 'GamificationService', ($http) ->
  new class
    getResultBoard: ->
      $http.get('/api/gamification/current').then (response) ->
        response.data
