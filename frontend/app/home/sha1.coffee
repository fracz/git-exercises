angular.module('git-exercises').filter 'sha1', ->
  (input) ->
    sha1(input)
