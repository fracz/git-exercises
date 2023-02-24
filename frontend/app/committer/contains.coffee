angular.module('git-exercises').filter 'contains', ->
  (array, needle) ->
    array and needle in array
