angular.module('git-exercises').component 'resultBoard',
  templateUrl: 'gamification/result-board.html'
  controller: (GamificationService) ->
    new class
