<?php

/*
 *  JavaScript Array v1.0
 *  http://www.jsphp.org
 *
 *  Copyright (c) 2010-2013 James Watts (SOLFENIX)
 *  http://www.solfenix.com
 *
 *  This is FREE software, licensed under the GPL
 *  http://www.gnu.org/licenses/gpl.html
 */

/*
 * @package     Solfenix
 * @subpackage  JSPHP
 * @author      James Watts <contact@jameswatts.info>
 * @copyright   2010-2013 James Watts (SOLFENIX)
 * @license     http://www.gnu.org/licenses/gpl.html
 * @link        http://www.solfenix.com
 * @version     1.0
 */

namespace Solfenix\JSPHP;

use ReflectionClass;
use Closure;

use Solfenix\JSPHP\JSObject;
use Solfenix\JSPHP\JSDataType;
use Solfenix\JSPHP\JSPrototype;
use Solfenix\JSPHP\JSFunction;
use Solfenix\JSPHP\JSString;
use Solfenix\JSPHP\JSNull;

/* JSArray
 *
 * Class to create a new JavaScript array object
 *
 * @author James Watts
 * @version 1.0
 */

class JSArray extends JSObject {

	public $length = 0;

	public function __construct() {
		$arguments = func_get_args();
		for ( $i = 0; $i < count( $arguments ); $i++ ) {
			if ( !( $arguments[$i] instanceof JSDataType ) ) $arguments[$i] = JSDataType::__define( $arguments[$i] );
		}
		$this->__valueOf   = $arguments;
		$this->__prototype = JSPrototype::__instance( get_class( $this ), $this );
		$this->length      = count( $this->__valueOf );
	}

	public function __toString() {
		return implode( ',', &$this->__valueOf );
	}

	public function valueOf( $index = null ) {
		if ( isset( $index ) ) return ( isset( $this->__valueOf[$index] ) ) ? $this->__valueOf[$index] : undefined;
		return $this->__valueOf;
	}

	public function concat() {
		$arguments = func_get_args();
		for ( $i = 0; $i < count( $arguments ); $i++ ) {
			if ( !( $arguments[$i] instanceof JSDataType ) ) $arguments[$i] = JSDataType::__define( $arguments[$i] );
			$this->__valueOf[] = $arguments[$i];
		}
		$this->length = count( $this->__valueOf );
		return $this;
	}

	public function every( $callback, $scope = null ) {
		$callback = ( $callback instanceof JSFunction ) ? $callback : JSDataType::__resolve( $callback, JSDataType::TYPE_FUNCTION );
		if ( !is_null( $scope ) ) $scope = JSDataType::__resolve( $scope, JSDataType::TYPE_OBJECT );
		for ( $i = 0; $i < count( $this->__valueOf ); $i++ ) {
			if ( $scope ) {
				if ( !$callback->call( $scope, $this->__valueOf[$i], $i, $this ) ) return false;
			} else {
				if ( !$callback( $this->__valueOf[$i], $i, $this ) ) return false;
			}
		}
		return true;
	}

	public function filter( $callback, $scope = null ) {
		$array    = array();
		$callback = ( $callback instanceof JSFunction ) ? $callback : JSDataType::__resolve( $callback, JSDataType::TYPE_FUNCTION );
		if ( !is_null( $scope ) ) $scope = JSDataType::__resolve( $scope, JSDataType::TYPE_OBJECT );
		for ( $i = 0; $i < count( $this->__valueOf ); $i++ ) {
			if ( $scope ) {
				if ( $callback->call( $scope, $this->__valueOf[$i], $i, $this ) ) $array[] = $this->__valueOf[$i];
			} else {
				if ( $callback( $this->__valueOf[$i], $i, $this ) ) $array[] = $this->__valueOf[$i];
			}
		}
		return new static( $array );
	}

	public function forEachIndex( $callback, $scope = null ) {
		$callback = ( $callback instanceof JSFunction ) ? $callback : JSDataType::__resolve( $callback, JSDataType::TYPE_FUNCTION );
		if ( !is_null( $scope ) ) $scope = JSDataType::__resolve( $scope, JSDataType::TYPE_OBJECT );
		for ( $i = 0; $i < count( $this->__valueOf ); $i++ ) {
			if ( $scope ) {
				$callback->call( $scope, $this->__valueOf[$i], $i, $this );
			} else {
				$callback( $this->__valueOf[$i], $i, $this );
			}
		}
		return $this;
	}

	public function indexOf( $value = null, $start = 0 ) {
		$start = JSDataType::__resolve( $start, JSDataType::TYPE_NUMBER );
		if ( abs( $start ) >= count( $this->__valueOf ) ) return undefined;
		if ( $start < 0 ) $start = count( $this->__valueOf )-abs( $start )-1;
		for ( $i = $start; $i < count( $this->__valueOf ); $i++ ) {
			if ( $this->__valueOf[$i] === $value ) return $i;
		}
		return undefined;
	}

	public function join( $value = '' ) {
		return new JSString( implode( JSDataType::__resolve( $value ), &$this->__valueOf ) );
	}

	public function lastIndexOf( $value = null, $start = 0 ) {
		$start = JSDataType::__resolve( $start, JSDataType::TYPE_NUMBER );
		if ( abs( $start ) >= count( $this->__valueOf ) ) return undefined;
		if ( $start < 0 ) $start = count( $this->__valueOf )-abs( $start )-1;
		for ( $i = count( $this->__valueOf )-1; $i <= $start; $i-- ) {
			if ( $this->__valueOf[$i] === $value ) return $i;
		}
		return undefined;
	}

	public function map( $callback, $scope = null ) {
		$array    = array();
		$callback = ( $callback instanceof JSFunction ) ? $callback : JSDataType::__resolve( $callback, JSDataType::TYPE_FUNCTION );
		if ( !is_null( $scope ) ) $scope = JSDataType::__resolve( $scope, JSDataType::TYPE_OBJECT );
		for ( $i = 0; $i < count( $this->__valueOf ); $i++ ) {
			if ( $scope ) {
				$array[] = $callback->call( $scope, $this->__valueOf[$i], $i, $this );
			} else {
				$array[] = $callback( $this->__valueOf[$i], $i, $this );
			}
		}
		return new JSArray( $array );
	}

	public function pop() {
		$value        = array_pop( $this->__valueOf );
		$this->length = count( $this->__valueOf );
		return JSDataType::__define( $value );
	}

	public function push() {
		$arguments = func_get_args();
		for ( $i = 0; $i < count( $arguments ); $i++ ) {
			if ( !( $arguments[$i] instanceof JSDataType ) ) $arguments[$i] = JSDataType::__define( $arguments[$i] );
			$this->__valueOf[] = $arguments[$i];
		}
		$this->length = count( $this->__valueOf );
		return $this;
	}

	public function reduce( $callback, $initial = null ) {
		$value = JSDataType::__resolve( $initial, JSDataType::TYPE_STRING );
		for ( $i = 0; $i < count( $this->__valueOf ); $i++ ) $value .= $callback( $value, $this->__valueOf[$i], $i, $this );
		return new JSString( $value );
	}

	public function reduceRight( $callback, $initial = null ) {
		$value = JSDataType::__resolve( $initial, JSDataType::TYPE_STRING );
		for ( $i = 0; $i < count( $this->__valueOf ); $i++ ) {
			if ( $this->__valueOf[$i] !== null && !( $this->__valueOf[$i] instanceof JSNull ) ) $value .= $callback( $value, $this->__valueOf[$i], $i, $this );
		}
		return new JSString( $value );
	}

	public function reverse() {
		$this->__valueOf = array_reverse( $this->__valueOf );
		return $this;
	}

	public function shift() {
		$value = array_shift( $this->__valueOf );
		$this->length = count( $this->__valueOf );
		return JSDataType::__define( $value );
	}

	public function slice( $start = 0, $end = 0 ) {
		$class = new ReflectionClass( 'JSArray' );
		return $class->newInstanceArgs( array_slice( $this->__valueOf, JSDataType::__resolve( $start, JSDataType::TYPE_NUMBER ), JSDataType::__resolve( $end, JSDataType::TYPE_NUMBER )-JSDataType::__resolve( $start, JSDataType::TYPE_NUMBER ) ) );
	}

	public function some( $callback, $scope = null ) {
		$callback = ( $callback instanceof JSFunction ) ? $callback : JSDataType::__resolve( $callback, JSDataType::TYPE_FUNCTION );
		if ( !is_null( $scope ) ) $scope = JSDataType::__resolve( $scope, JSDataType::TYPE_OBJECT );
		for ( $i = 0; $i < count( $this->__valueOf ); $i++ ) {
			if ( $scope ) {
				if ( $callback->call( $scope, $this->__valueOf[$i], $i, $this ) ) return true;
			} else {
				if ( $callback( $this->__valueOf[$i], $i, $this ) ) return true;
			}
		}
		return false;
	}

	public function sort( $function = null ) {
		if ( $function instanceof Closure ) {
			usort( $this->__valueOf, $function );
		} elseif ( $function instanceof JSFunction ) {
			usort( $this->__valueOf, $function->valueOf() );
		} else {
			sort( $this->__valueOf );
		}
		return $this;
	}

	public function splice() {
		$arguments = func_get_args();
		for ( $i = 0; $i < count( $arguments ); $i++ ) {
			if ( !( $arguments[$i] instanceof JSDataType ) ) $arguments[$i] = JSDataType::__define( $arguments[$i] );
		}
		$array = array_splice( $this->__valueOf, JSDataType::__resolve( $arguments[0], JSDataType::TYPE_NUMBER ), JSDataType::__resolve( $arguments[1], JSDataType::TYPE_NUMBER ) );
		if ( count( $arguments ) > 2 ) {
			array_splice( $arguments, 0, 2 );
			array_unshift( $arguments, &$this->__valueOf );
			call_user_func_array( 'array_push', $arguments );
		}
		$this->length = count( $this->__valueOf );
		if ( count( $array ) === 1 ) return JSDataType::__define( $array[0] );
		$class = new ReflectionClass( 'JSArray' );
		return $class->newInstanceArgs( $array );
	}

	public function unshift() {
		$arguments = func_get_args();
		for ( $i = 0; $i < count( $arguments ); $i++ ) {
			if ( !( $arguments[$i] instanceof JSDataType ) ) $arguments[$i] = JSDataType::__define( $arguments[$i] );
		}
		array_unshift( $arguments, &$this->__valueOf );
		call_user_func_array( 'array_unshift', $arguments );
		$this->length = count( $this->__valueOf );
		return $this;
	}

	public function isArray() {
		return true;
	}
}

