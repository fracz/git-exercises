angular.module('git-exercises').component 'resultBoard',
  templateUrl: 'gamification/result-board.html'
  controller: (GamificationService, $timeout) ->
    new class
      $onInit: ->
        @resultBoard = []
        @fetch()

      fetch: =>
        GamificationService.getResultBoard()
          .then (newResults) =>
            newResults = newResults.slice(0, 7)
            delete item.place for item in @resultBoard
            item.place = newResults.findIndex((i) -> i.committer_name is item.committer_name) for item in newResults
            item.place = newResults.findIndex((i) -> i.committer_name is item.committer_name) for item in @resultBoard
            @resultBoard.splice(@resultBoard.indexOf(item), 1) for item in @resultBoard.filter((i) -> i.place < 0)
            @resultBoard.push(item) for item in newResults when @resultBoard.findIndex((i) -> i.committer_name is item.committer_name) < 0
            @resultBoard.splice(7)
            angular.extend(item, newResults.find((i) -> i.committer_name is item.committer_name)) for item in @resultBoard
          .finally(=> $timeout(@fetch, 3000))
