angular.module('git-exercises').service 'GamificationService', ($http, $q) ->
  new class
    getResultBoard: (id = '', password = '') ->
#      names = ['Anna Bukowska', 'Borowiec Piotr', 'Czarnecki Witold', 'Dorota Babczyk', 'Emil Bugajski',
#        'Frącz Wojciech', 'Genowefa Pigwa', 'Hubert Urbański', 'Ignacy Iksiński', 'Jan Kowalski', 'Krzysztof Śmiałek']
#      results = for i in [0..Math.floor(Math.random() * names.length)]
#        committer_name: names[i]
#        failed: Math.round(Math.random() * 20)
#        passed: Math.round(Math.random() * 20)
#        points: Math.random() * 100
#
#      $q.when(results.sort((a, b) -> b.points - a.points))
      $http.get('/api/gamification/current?id=' + id, {headers: {Auth: password}}).then (response) ->
        response.data

    endCurrentSession: (password) ->
      $http.delete('/api/gamification/current', {headers: {Auth: password}})

    startNewSession: (duration, password) ->
      $http.post('/api/gamification?duration=' + duration, {}, {headers: {Auth: password}})
