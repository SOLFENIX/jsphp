<?php

/*
 *  JavaScript Function v1.0
 *  http://www.jsphp.org
 *
 *  Copyright (c) 2010-2013 James Watts (SOLFENIX)
 *  http://www.solfenix.com
 *
 *  This is FREE software, licensed under the GPL
 *  http://www.gnu.org/licenses/gpl.html
 */

namespace Solfenix\JSPHP;

use Closure;

use Solfenix\JSPHP\JSObject;
use Solfenix\JSPHP\JSPrototype;
use Solfenix\JSPHP\JSDataType;
use Solfenix\JSPHP\JSTypeError;

/* JSFunction
 *
 * Class to create a new JavaScript function object
 *
 * @author James Watts
 * @version 1.0
 */

class JSFunction extends JSObject {

	public $__scope = null;

	public $__arguments = null;

	public function __construct( $function = null, $scope = null, $arguments = null ) {
		$this->__valueOf   = ( $function instanceof Closure ) ? $function : function() { return; };
		$this->__scope     = $scope;
		$this->__arguments = $arguments;
		$this->__prototype = JSPrototype::__instance( get_class( $this ), $this );
	}

	public function __invoke() {
		return call_user_func_array( $this->__valueOf, func_get_args() );
	}

	public function __toString() {
		return '[object Function]';
	}

	public function call() {
		return call_user_func_array( $this->__valueOf, func_get_args() );
	}

	public function apply( $scope = null, $arguments = array() ) {
		$arguments = JSDataType::__resolve( $arguments, JSDataType::TYPE_ARRAY );
		array_unshift( $arguments, $scope );
		return call_user_func_array( $this->__valueOf, $arguments );
	}

	public function bind() {
		$arguments = func_get_args();
		if ( count( $arguments ) < 1 ) throw new JSTypeError();
		$scope = $arguments[0];
		array_shift( $arguments );
		return new static( $this->__valueOf, $scope, $arguments );
	}
}

