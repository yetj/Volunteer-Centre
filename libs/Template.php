<?php

class Template {

    
	protected $_vars = array();
	protected $_vars_used = array();
	protected $_templates_used = array();
	protected $_ext = '.tpl.php';
	protected $_paths = array(
		'templates' => '',
	);
	protected $_extract = true;
	protected static $_active_view;

	
	public function __get($key){
		return $this->get($key);
	}

	public function __set($key, $value = null) {
		return $this->assign($key, $value);
	}

	public function __unset($key) {
		return $this->unassign($key);
	}

	public function __isset($key) {
	    	return $this->isAssigned($key);
	}

	public function __toString() {
		$return = " ~ template variables:\n";
		foreach($this->_vars as $key => $value){
			$return .= "\t$key => " . var_export($value, true);
		}
		$return .= " ~ unused variables:\n";
		foreach(array_diff_key($this->_vars, $this->_vars_used) as $key => $value){
			$return .= "\t$key => " . var_export($value, true);
		}
		$return .= " ~ leaked variables:\n";
		foreach(array_diff_key($this->_vars_used, $this->_vars) as $key => $value){
			$return .= "\t$key";
		}
		$return .= "\n ~ template directory: {$this->_paths['template']}\n";
		$return .= " ~ fetched templates:\n";
		foreach($this->_templates_used as $key => $value){
			$return .= "\t$key: " . $value . "\n";
		}
		return $return;
	}

	public function setPath($which, $path='') {
		if(isset($this->_paths[$which])) {
			$this->_paths[$which] = $path;
		}
		return $this;
	}
	
	public function get($key) {
		$this->_vars_used[$key] = $key;
		return isset( $this->_vars[$key] ) ? $this->_vars[$key] : null;
	}

	public function assign($key, $value = null) {
		if(func_num_args() > 1)
			$this->_vars[$key] = $value;

		if( is_array( $key ) || is_object( $key ) ) {
			foreach($key as $prop => $value) {
				$this->_vars[$prop] = $value;
			}
		}
		return $this;
	}

    public function unassign($key) {
		unset( $this->_vars_used[$key] );
		unset( $this->_vars[$key] );
		return $this;
    }

    public function isAssigned($key) {
    	return isset( $this->_vars[$key] );
    }

    public function getVars() {
        return $this->_vars;
    }

    public function templateExists($template) {
        return file_exists( $this->_paths['templates'] . $template . $this->_ext );
    }

    public function setExtract($extract = true) {
    	$this->_extract = $extract;
    	return $this;
    }

    public function setExtension($ext) {
    	$this->_ext = $ext;
    	return $this;
    }

	protected function _render($__template, array $__vars=array()) {
		// extract view vars?
		if($this->_extract) {
			extract($__vars, EXTR_REFS);
		}

		// mark this template as used
		$this->_templates_used[] = $__template . $this->_ext;

		// make filename for template and include it
		$__tpl = $this->_paths['templates'] . $__template . $this->_ext;
		include $__tpl;
	}

	public function render($template) {
		self::$_active_view = $this;
		return $this->element($template, $this->_vars);
	}

	public function element($template, array $vars=null) {
		if(empty($vars)) {
			$vars = $this->_vars;
		}

		// catch output of _render and return it
		ob_start();
		$this->_render($template, $vars);
		$output = ob_get_clean();

		return $output;
    }

	public static function getActiveView() {
		return self::$_active_view;
	}
}
