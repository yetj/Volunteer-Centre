<?php

define('URL_ROOT', 'http://inzynierka/');

define('ROOT', realpath(dirname(__FILE__) . '/..') . '\\');

require_once(ROOT . 'app/config/bootstrap.php');

try {
	$controller = Router::get()->getController();
	$response = $controller->handle();
	$response->send();
}
catch (ControllerNotFoundException $e) {
	header("Location: /");
	die();
}
/*
catch (PublicException $e) {
    echo 'ups błąd: ' . $e->getMessage();
    die();
}
*/