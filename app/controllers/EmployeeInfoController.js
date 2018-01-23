app.controller('EmployeeInfoController', ['$scope', 'NamesGetter', 'InfoGetter',
	function($scope, NamesGetter, InfoGetter){
 	$scope.selectedId = null;
  	$scope.names = {};
  	$scope.employeeInfo = {};
  	$scope.getNames = function(term) {
    	NamesGetter.getNames(term).then(function(names){
      		$scope.names = names;
    	});
  	}
  	$scope.getInfo = function() {
  		$scope.selectedId = $('#selectedId').val();
  		if($scope.selectedId !== null) {
  			InfoGetter.getInfo($scope.selectedId).then(function(employeeInfo){
  				$scope.fullName = employeeInfo.first_name + " " + employeeInfo.surname;
      			$scope.takeHome = employeeInfo.take_home + " BGN";
      			$scope.incomeTax = employeeInfo.income_tax + " BGN";
      			$scope.nationalInsurance = employeeInfo.national_insurance + " BGN";
    		});		
  		}
  	}
}]);