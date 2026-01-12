<?php

class View extends Template {
	public function __construct($app) {

		// include helper functions
		$functionsPath = ROOT . 'app/view/functions/';
		foreach(glob($functionsPath . '*.php') as $file) {
			require_once($file);
		}

		// Set the template path
		$this->setPath('templates', ROOT . 'app/view/' . $app . '/');
	}
}