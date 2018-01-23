<?php

namespace Server\Data;

interface IRepository
{
	public function getAllEmployees();
	public function getAllEmployeesNames($term);
	public function getEmployeeById($id);
	public function getEmployeeByName($name);
}
