angular.module('git-exercises').directive 'sourceCodeJumbotron', ->
  scope:
    code: '=sourceCodeJumbotron'
  templateUrl: 'home/source-code-jumbotron.html'
