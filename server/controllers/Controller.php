<?php

namespace Server\Controllers;

use Server\Data\SQLRepo;

abstract class Controller
{
	protected $repo;

	public function __construct() {
		$this->repo = new SQLRepo();
	}

	protected function response($code, $msg) {
		http_response_code($code);
		echo json_encode($msg);
	}
}
