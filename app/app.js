var app = angular.module('FourthEmployeeInfoApp', ['ngRoute']);

app.config(['$routeProvider', function($routeProvider) {
	$routeProvider.when('/', {
		templateUrl: 'views/home.html',
		controller: 'HomeController'
	});
	$routeProvider.when('/employee-info', {
		templateUrl: 'views/employee_info.html',
		controller: 'EmployeeInfoController'
	});
	$routeProvider.otherwise({
        redirectTo: '/'
      });
}]);