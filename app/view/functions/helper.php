<?php

function publicURL($link, $controller = '', $action = 'index', $params = []) {
	
	$url = "";
	
	if($controller) {
		$url = "/$link/$controller/$action";
	
		foreach($params as $key => $value) {
			$url .= "/$key/$value";
		}
	}
	else {
		$url = "/$link";
	}
	
	return $url;
}

function adminURL($controller, $action = 'index', $params = []) {
	$currentParams = Router::get()->getParams();
	$url = "/admin/$controller/$action";
	
	if(isset($currentParams['project']) && !isset($params['project'])) {
		$params['project'] = $currentParams['project'];
	}
	
	foreach($params as $key => $value) {
		$url .= "/$key/$value";
	}
	
	return $url;
}

function cutText($text, $length=15) {
	$strlen = strlen($text);
	if($strlen > $length) {
		$text_new = substr($text,0,$length);
		$text = '<span title="'.htmlspecialchars($text).'">'.$text_new.'...</span>';
		return $text;
	}
	else {
		return $text;
	}
}