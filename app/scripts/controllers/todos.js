'use strict';

angular.module('mytodoApp')
  .controller('MainCtrl', function ($scope, Todo) {

    //fetch all todos
    $scope.todos = Todo.query();

    $scope.delete = function(todo){
      todo.$delete();
      $scope.todos.splice($scope.todos.indexOf(todo), 1);
    };
      

    $scope.add = function(){
      var todo = new Todo();
      todo.name = $scope.name;
      todo.$save();
      $scope.todos.push(todo);
    };


    $scope.update = function(todo){
      todo.$update();
    };


  });
