<?php

include ROOT . '/app/includes/VC.php';

VC::loadClasses();

if (VC::config()->debug) {
	ini_set("display_errors", "on");
	ini_set("error_reporting", E_ALL);
}

class PublicException extends Exception {}
class PublicExceptionSuccess extends Exception {}
class ControllerNotFoundException extends Exception {}