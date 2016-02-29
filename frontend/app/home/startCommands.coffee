angular.module('git-exercises').directive 'startCommands', ->
  templateUrl: 'home/start-commands.html'
  scope: yes
  link: ($scope) ->
    $scope.commands = ->
      """git clone http://gitexercises.fracz.com/git/exercises.git
cd exercises
git config user.name "#{$scope.you?.name?.replace(/"/g, '\\"') or 'Your name here'}"
git config user.email "#{ $scope.you?.email?.replace(/"/g, '\\"') or 'Your e-mail here'}"
./configure.sh
git start"""
