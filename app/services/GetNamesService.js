app.service('NamesGetter', function($q, $http){
  	var API_URL = 'http://localhost:8080/fourth/public/api/employees-names/';
  	this.getNames = function(term) {
	    var deferred = $q.defer();
	 	$http.get(API_URL + term).then(function(names){
	   		var names = names.data;
			deferred.resolve(names);
		}, function() {
			deferred.reject(arguments);
		});

		return deferred.promise;
  	} 
})