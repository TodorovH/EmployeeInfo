app.service('InfoGetter', function($q, $http){
  	var API_URL = 'http://localhost:8080/fourth/public/api/employee/by-id/';
  	this.getInfo = function(term) {
	    var deferred = $q.defer();
	 	$http.get(API_URL + term).then(function(employeeInfo){
	   		var employeeInfo = employeeInfo.data;
			deferred.resolve(employeeInfo[0]);
		}, function() {
			deferred.reject(arguments);
		});

		return deferred.promise;
  	} 
})