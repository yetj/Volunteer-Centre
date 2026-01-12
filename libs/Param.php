<?php

/**
 * Sanitize POST/GET data
 */
class Param {

	public static function str(array $arr, $index, $default='') {
		if (array_key_exists($index, $arr)) {
			return (string) $arr[$index];
		}
		return $default;
	}

	public static function bool(array $arr, $index, $default = false) {
		if (array_key_exists($index, $arr)) {
			$true_values = array(
				'true',
				'on',
				'1',
				1,
				true
			);
			$false_values = array(
				'false',
				'off',
				'0',
				0,
				false
			);
			if (in_array($arr[$index], $true_values, true)) {
				return true;
			} else if (in_array($arr[$index], $false_values, true)) {
				return false;
			}
		}
		return $default;
	}

	public static function int(array $arr, $index, $default=0) {
		if (array_key_exists($index, $arr)) {
			return (int) $arr[$index];
		}
		return $default;
	}

	public static function float(array $arr, $index, $default=0) {
		if (array_key_exists($index, $arr)) {
			return (float) $arr[$index];
		}
		return $default;
	}

	public static function arr(array $arr, $index, array $default=array()) {
		if (array_key_exists($index, $arr) && is_array($arr[$index])) {
			return $arr[$index];
		}
		return $default;
	}
}
