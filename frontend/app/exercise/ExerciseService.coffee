angular.module('git-exercises').service 'ExerciseService', ($http) ->
  new class
    getAll: ->
      $http.get('/api/exercise', cache: yes).then (response) ->
        response.data
