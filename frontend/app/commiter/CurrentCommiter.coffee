angular.module('git-exercises').service 'CurrentCommiter', ($http, $rootScope, $q, $interval, ipCookie) ->

  refreshing = null

  new class
    constructor: ->
      @currentCommiter = ipCookie('currentCommiter')
      @set(@currentCommiter) if @currentCommiter

    set: (@currentCommiter) =>
      ipCookie('currentCommiter', @currentCommiter, {expires: 21, path: '/'})
      $rootScope.currentCommiter =
        id: @currentCommiter
      @fetchData()
      refreshing = $interval(@fetchData, 30000) if not refreshing

    getId: =>
      @currentCommiter

    fetchData: =>
      defer = $q.defer()
      if @currentCommiter
        $http.get('/api/commiter/' + @currentCommiter).success (response) ->
          angular.extend($rootScope.currentCommiter, response)
          defer.resolve(response)
      else
        defer.resolve(null)
      defer.promise

    getData: =>
      $rootScope.currentCommiter or {}
