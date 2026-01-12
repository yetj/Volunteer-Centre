<?php

class Response {
	protected $headers = array();
	protected $cookies = array();
	protected $body = '';

	// TODO Remove this contructor
	public function __construct($body=null) {
		$this->body = $body;
	}

	public function setHeader($name, $value, $replace = true) {
		$this->headers[] = array('name' => $name, 'value' => $value, 'replace' => $replace);
	}

	public function getHeaders() {
		return $this->headers;
	}

	public function setCookie($name, $value, $expires = 0, $path = '/') {
		$this->cookies[] = array('name' => $name, 'value' => $value, 'expires' => $expires, 'path' => $path);
	}

	public function setCookieWithDomain($name, $value, $expires = 0, $path = '/', $domain = '') {
		$this->cookies[] = array('name' => $name, 'value' => $value, 'expires' => $expires, 'path' => $path, 'domain' => $domain);
	}

	public function getCookies() {
		return $this->cookies;
	}

	public function setStatus($status) {
		$this->setHeader('Status', $status);
	}

	public function setRedirect($url) {
		$this->setHeader('Location', $url);
	}

	public function setBody($body) {
		$this->body = $body;
	}

	public function getBody() {
		return $this->body;
	}

	public function send() {
		$this->sendHeaders();
		$this->sendCookies();
		$this->sendBody();
	}

	public function sendHeaders() {
		foreach($this->headers as $header) {
			header($header['name'] . ': ' . $header['value'], $header['replace']);
		}
	}

	public function sendCookies() {
		foreach($this->cookies as $cookie) {
			$expire = $cookie['expires'] <> 0 ? $cookie['expires'] : 0;

			setcookie($cookie['name'], $cookie['value'], $expire, $cookie['path']);
		}
	}

	public function sendBody() {
		echo $this->body;
	}
}