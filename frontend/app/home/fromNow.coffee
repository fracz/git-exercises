angular.module('git-exercises').filter 'fromNow', ->
  (date) ->
    moment(date).fromNow()
