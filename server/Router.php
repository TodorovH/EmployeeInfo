<?php

namespace Server;

class Router
{
	private static $getRoutes = [
		'employees' => [
			'controller' => 'EmployeesController',
			'action' => 'getAllEmployees'
		],
		'employees-names/{term}' => [
			'controller' => 'EmployeesController',
			'action' => 'getAllEmployeesNames'
		],
		'employee/by-id/{id}' => [
			'controller' => 'EmployeesController',
			'action' => 'getEmployeeById'
		],
		'employee/by-name/{name}' => [
			'controller' => 'EmployeesController',
			'action' => 'getEmployeeByName'
		]
	];

	private static $postRoutes = [];

	private static function asTree($route, &$tree = []) {
		if(count($route) > 0) {
			$tree[$route[0]] = self::asTree(array_slice($route, 1));
		}

		return $tree;
	}

	private static function getRouteTree($routes) {
		$tree = [];
		foreach ($routes as $url => $route) {
			$subtree = self::asTree(explode('/', $url));
			$tree = array_merge_recursive($tree, $subtree);
		}

		return $tree;
	}

	private static function getRoute(&$tree, $parts, &$variables = [], $acc = "") {
		if(count($parts) > 0 && array_key_exists($parts[0], $tree)) {
			$acc .= "/" . $parts[0];
			$acc = self::getRoute($tree[$parts[0]], array_slice($parts, 1), $variables, $acc);
		} else if(count($parts) > 0) {
			foreach ($tree as $key => $value) {
				if(preg_match('/\{(.*?)(:.*?)?(\{[0-9,]+\})?\}/', $key)) {
					$acc .= "/" . $key;
					array_push($variables, $parts[0]);
					$acc = self::getRoute($tree[$key], array_slice($parts, 1), $variables, $acc);
				}
			}
		} else {
			$acc = ltrim($acc, '/');
		}

		return $acc;
	} 

	public static function route($url, $method) {

		$url = explode('/', $url);

		$routes = [];
		if($method === "GET") {
			$routes = self::$getRoutes;
		} else if($method === "POST") {
			$routes = self::$postRoutes;
		}

		$variables = [];
		$tree = self::getRouteTree($routes);
		$routeKey = self::getRoute($tree, $url, $variables);

		if(array_key_exists($routeKey, $routes)) {
			$route = $routes[$routeKey];

			$controller = "Server\\Controllers\\" . $route['controller'];

			if(class_exists($controller)) {
				$ds = new $controller;

				call_user_func_array(array($ds, $route['action']), $variables);
			} else {
				echo "Not found";
			}
		} else {
			echo "No such route";
		}
	}
}
