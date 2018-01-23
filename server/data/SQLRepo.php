<?php

namespace Server\Data;

class SQLRepo implements IRepository
{
	private $con;

	public function __construct() {
		$this->con = mysqli_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASSWORD'), getenv('DB_NAME'));
	}

	public function getAllEmployees() {
		$stmt = $this->con->prepare("select * from employees");
		$stmt->execute();
		$stmt->bind_result($id, $gender, $title, $firstName, $surname,
			$dateOfBirth, $age, $salary, $takeHome, $incomeTax, $nationalInsurance);

		while($stmt->fetch()) {
			$output[] = array(
				'id' => $id,
				'first_name' => $firstName
			);
		}

		$stmt->close();
		$this->con->close();

		return $output;
	}

	public function getAllEmployeesNames($term) {
		$stmt = $this->con->prepare("select id, first_name, surname from employees where first_name like
			CONCAT(?, '%') or surname like CONCAT(?, '%')");
		$stmt->bind_param("ss", $term, $term);
		$stmt->execute();
		$stmt->bind_result($id, $firstName, $surname);
		$output = array();

		while($stmt->fetch()) {
			array_push($output, array('id' => $id, 'name' => $firstName), array('id' => $id, 'name' => $surname));
		}

		$stmt->close();
		$this->con->close();

		return $output;
	}

	public function getEmployeeById($id) {
		$stmt = $this->con->prepare("select * from employees where id=?");
		$stmt->bind_param("i", $id);

		$stmt->execute();
		$stmt->bind_result($id, $gender, $title, $firstName, $surname,
			$dateOfBirth, $age, $salary, $takeHome, $incomeTax, $nationalInsurance);

		while($stmt->fetch()) {
			$output[] = array(
				'id' => $id,
				'first_name' => $firstName,
				'surname' => $surname,
				'take_home' => $takeHome,
				'income_tax' => $incomeTax,
				'national_insurance' => $nationalInsurance
			);
		}

		$stmt->close();
		$this->con->close();

		return $output;
	}

	public function getEmployeeByName($name) {
		$stmt = $this->con->prepare("select * from employees where first_name=? or surname=?");
		$stmt->bind_param("ss", $name, $name);

		$stmt->execute();
		$stmt->bind_result($id, $gender, $title, $firstName, $surname,
			$dateOfBirth, $age, $salary, $takeHome, $incomeTax, $nationalInsurance);

		while($stmt->fetch()) {
			$output[] = array(
				'id' => $id,
				'first_name' => $firstName,
				'surname' => $surname,
				'take_home' => $takeHome,
				'income_tax' => $incomeTax,
				'national_insurance' => $nationalInsurance
			);
		}

		$stmt->close();
		$this->con->close();

		return $output;
	}
}
