<?php

namespace Server\Controllers;

class EmployeesController extends Controller
{
	public function getAllEmployees() {

		$employees = $this->repo->getAllEmployees();

		$this->response(200, $employees);
	}

	public function getAllEmployeesNames($term) {

		$employeesNames = $this->repo->getAllEmployeesNames($term);

		$this->response(200, $employeesNames);
	}

	public function getEmployeeById($id) {
		
		$employee = $this->repo->getEmployeeById($id);

		$this->response(200, $employee);
	}

	public function getEmployeeByName($name) {
		
		$employee = $this->repo->getEmployeeByName($name);

		$this->response(200, $employee);
	}
}
