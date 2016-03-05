angular.module('git-exercises').service 'CurrentCommitter', ($http, $rootScope, $q, $interval, ipCookie) ->
  refreshing = null

  new class
    constructor: ->
      @currentCommitterId = ipCookie('currentCommitter')
      @set(@currentCommitterId) if @currentCommitterId

    set: (@currentCommitterId) =>
      ipCookie('currentCommitter', @currentCommitterId, {expires: 21, path: '/'})
      $rootScope.currentCommitter ?= {}
      $rootScope.currentCommitter.id = @currentCommitterId
      @fetchData()
      refreshing = $interval((=> @fetchData()), 30000) if not refreshing

    getId: =>
      @currentCommitterId

    fetchData: (id = @currentCommitterId) =>
      defer = $q.defer()
      if id
        $http.get('/api/committer/' + id).success (response) =>
          angular.extend($rootScope.currentCommitter, response) if id is @currentCommitterId
          defer.resolve(response)
      else
        defer.resolve(null)
      defer.promise

    getData: =>
      $rootScope.currentCommitter or {}
