angular.module('git-exercises').service 'CurrentCommitter', ($http, $rootScope, $q, $interval, ipCookie) ->
  refreshing = null

  new class
    constructor: ->
      @currentCommitter = ipCookie('currentCommitter')
      @set(@currentCommitter) if @currentCommitter

    set: (@currentCommitter) =>
      ipCookie('currentCommitter', @currentCommitter, {expires: 21, path: '/'})
      $rootScope.currentCommitter ?= {}
      $rootScope.currentCommitter.id = @currentCommitter
      @fetchData()
      refreshing = $interval(@fetchData, 30000) if not refreshing

    getId: =>
      @currentCommitter

    fetchData: =>
      defer = $q.defer()
      if @currentCommitter
        $http.get('/api/committer/' + @currentCommitter).success (response) ->
          angular.extend($rootScope.currentCommitter, response)
          defer.resolve(response)
      else
        defer.resolve(null)
      defer.promise

    getData: =>
      $rootScope.currentCommitter or {}
