'use strict';

angular.module('mytodoApp', [
  'ngRoute',
  'ngCookies',
  'ngResource',
  'ngSanitize',
  'ui.sortable',
  'xeditable'
])
  .config(['$routeProvider', function($routeProvider){
    $routeProvider
      .when('/', {
        templateUrl: 'views/todos.html',
        controller: 'MainCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  }])
  .config(['$resourceProvider', function($resourceProvider) {
    // this is to allow calling GET /todos/ instead of /todos
    $resourceProvider.defaults.stripTrailingSlashes = false;
  }])
  .factory('Todo', ['$resource', function($resource){
      return $resource('/todos/:id', {id:'@id'}, {
        update: {
          method: 'PUT' // this method issues a PUT request
        }
      });
    }])
  .run(function(editableOptions) {
      editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
    });
