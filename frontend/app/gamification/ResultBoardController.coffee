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
        @sound = 1
        @sounds = [
          new Audio('/images/sounds/your-turn.mp3')
          new Audio('/images/sounds/cheerful.mp3')
        ]

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
            oldPoints = @resultBoard.map((c) -> c.points).join('|')
            delete item.place for item in @resultBoard
            item.place = newResults.findIndex((i) -> i.committer_id is item.committer_id) for item in newResults
            item.place = newResults.findIndex((i) -> i.committer_id is item.committer_id) for item in @resultBoard
            @resultBoard.splice(@resultBoard.indexOf(item), 1) for item in @resultBoard.filter((i) -> i.place < 0)
            @resultBoard.push(item) for item in newResults when @resultBoard.findIndex((i) -> i.committer_id is item.committer_id) < 0
#            @resultBoard.splice(7)
            angular.extend(item, newResults.find((i) -> i.committer_id is item.committer_id)) for item in @resultBoard
            newPoints = @resultBoard.map((c) -> c.points).join('|')
            @playSound() if newPoints != oldPoints
          .catch =>
            @fetchError = true
            @currentSessionData = undefined
            @resultBoard = []
          .finally(=> $timeout(@fetch, 3000))

      playSound: =>
        sound = if +@sound == -1 then Math.floor(Math.random() * @sounds.length) else @sound
        @sounds[sound].play()

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
