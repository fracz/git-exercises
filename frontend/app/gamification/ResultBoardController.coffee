angular.module('git-exercises').component 'resultBoard',
  templateUrl: 'gamification/result-board.html'
  controller: (GamificationService, $timeout, $scope) ->
    new class
      $onInit: ->
        @theme = 'podium'
        @resultBoard = []
        @fetch()
        $(document).mousedown (e) =>
          if e.which == 2 or e.ctrlKey
            $scope.$apply(=> @adminFormVisible = !@adminFormVisible)

      fetch: =>
        if @desiredSessionId and @currentSessionData and @desiredSessionId != +@currentSessionData.id
          @currentSessionData = undefined
          @resultBoard = []
        GamificationService.getResultBoard(@desiredSessionId, @adminPassword)
          .then (response) =>
            @fetchError = false
            @currentSessionData = response.data
            newResults = response.board
#            newResults = newResults.slice(0, 7)
            delete item.place for item in @resultBoard
            item.place = newResults.findIndex((i) -> i.committer_name is item.committer_name) for item in newResults
            item.place = newResults.findIndex((i) -> i.committer_name is item.committer_name) for item in @resultBoard
            @resultBoard.splice(@resultBoard.indexOf(item), 1) for item in @resultBoard.filter((i) -> i.place < 0)
            @resultBoard.push(item) for item in newResults when @resultBoard.findIndex((i) -> i.committer_name is item.committer_name) < 0
#            @resultBoard.splice(7)
            angular.extend(item, newResults.find((i) -> i.committer_name is item.committer_name)) for item in @resultBoard
          .catch =>
            @fetchError = true
            @currentSessionData = undefined
            @resultBoard = []
          .finally(=> $timeout(@fetch, 3000))

      endCurrentSession: =>
        if confirm('Na pewno zakończyć sesję?')
          GamificationService.endCurrentSession(@adminPassword)
            .then =>
              @currentSessionData = undefined
              @resultBoard = []
            .catch(-> alert('Złe hasło?'))

      startNewSession: =>
        GamificationService.startNewSession(@newSessionDuration, @adminPassword)
          .then(=> @currentSessionData = {id: 'TBA'})
          .catch(-> alert('Złe hasło?'))
