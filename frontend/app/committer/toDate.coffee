angular.module('git-exercises').filter 'toDate', ->
  (input) ->
    moment(input).toDate()
