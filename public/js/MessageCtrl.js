var mailApp = angular.module('mailApp', ['ngRoute']);
mailApp.config(['$routeProvider','$locationProvider', function($routeProvider, $locationProvider){
  $routeProvider
        .when('/mailer', {
          templateUrl: '/public/js/view/messagelist.html',
          controller: 'ListCtrl',
          controllerAs: 'list'
        })
        .when('/mailer/:folder', {
          templateUrl: '/public/js/view/messagelist.html',
          controller: 'ListCtrl',
          controllerAs: 'list'
        })
        .when('/Compose', {
          templateUrl: '/public/js/view/compose.html',
          controller: 'ComposeCtrl',
          controllerAs: 'compose'
        })
	.when('/Message/:folder/:id', {
          templateUrl: '/public/js/view/message.html',
          controller: 'MessageCtrl',
          controllerAs: 'message'
        })
        .otherwise({
          redirectTo: '/mailer/INBOX'
        });
  $locationProvider.html5Mode(true);
}]);
mailApp.controller('MainCtrl', ['$route', '$routeParams', '$location',
    function($route, $routeParams, $location) {
      this.$route = $route;
      this.$location = $location;
      this.$routeParams = $routeParams;
  }]);
mailApp.controller('FolderCtrl', ['$scope','$http', function($scope, $http){
    $http({
        url: '/mailer/folders'
    }).success(function(data) { $scope.folders = data;});
}]);
mailApp.controller('MessageCtrl', ['$routeParams', '$http', function($routeParams, $http){
     $http({
        url: '/mailer/readmail?id='+$routeParams.id+'&folder='+$routeParams.folder,
	method: 'GET',
        headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'},
	data: $routeParams
    }).success(function(data) { $('#message').html(data);});
}]);
mailApp.controller('ComposeCtrl', ['$scope', '$http', function($scope, $http){

     $('#compose_email').summernote({height: 400, id: 'compose_email', name: 'body'});
     $scope.new_message = {};
     $scope.message = {};
     $scope.save = function(){
         $scope.message.body = $('#compose_email').code();
         $http({
             url:'/mailer/sendmail',
             method: 'POST',
             headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'},
             data: $scope.message
         });
     }
     $scope.reset = function(){
         $scope.message = angular.copy($scope.new_message);
     }
}]);
mailApp.controller('ListCtrl', ['$scope','$http' , '$location', '$routeParams',function ($scope, $http, $location, $routeParams) {

    if($routeParams.folder){
      $http({
        url: '/mailer/checkmail?folder='+$routeParams.folder
      }).success(function(data) { $scope.mail = data;});
    }
    else{
      $http({
        url: '/mailer/checkmail'
      }).success(function(data) { $scope.mail = data;});
    }

    $scope.columns = [{name:'from', label:'From'},{name:'subject', label:'Sujet'},{name:'date', label:'Date'}]
    $scope.sort= {
        column: 'date',
        descending: true
    };
    $scope.refresh = function(){
        $http({
            url: 'mailer/checkmail'
        }).success(function(data) { $scope.mail = data;});
    };
    $scope.showMessage = function(message){
        //$location.path('/Message/'+message.folder+'/'+message.id).replace();
        $.ajax({
            url:'/mailer/readmail?id='+message.id+'&folder='+message.folder,
            headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'},
            type:'GET'
        }).success(function(data){
            $('#message_consultation').html(data);
        });
    }
    $scope.selectMessage = function(message){
        /*$('tr').each(function(){
            $(this).removeClass('selected');
        })*/
        $('#message_'+message.id).toggleClass('selected')
        /*$.ajax({
            url:'readmail.php?id='+message.id+'&folder='+message.folder,
            headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'},
            type:'GET'
        }).success(function(data){
            $('#message_consultation').html(data);
        });*/
    }
}]);
mailApp.controller('MenuCtrl', ['$scope', '$http', function($scope, $http) {
  $scope.menus = [
    {label: 'Refresh', icon: 'refresh', url:'/mailer/INBOX'}, 
  ];
}]);
