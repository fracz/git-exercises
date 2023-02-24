angular.module('git-exercises').directive 'stateBasedCssClass', ($state) ->
  scope: no
  link: ($scope, $element) ->
    updateStateBasedCssClass = (state) ->
      stateClassName = state.name.replace(/[^a-z0-9]/ig, '-')
      $element.attr('class', "state-#{stateClassName}")
      if stateClassName.indexOf('-')
        $element.addClass('state-' + stateClassName.split('-')[0])

    $scope.$on '$stateChangeSuccess', (event, state) ->
      updateStateBasedCssClass(state)

    updateStateBasedCssClass($state.current)
